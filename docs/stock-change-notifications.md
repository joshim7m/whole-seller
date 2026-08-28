# Stock Change Notifications — Implementation Plan

## Overview

When an admin updates a product's quantity in the admin panel, the storefront should notify all wholeseller users about the stock status change — either "In Stock" (quantity goes from 0 to >0) or "Out of Stock" (quantity goes from >0 to 0). Notifications are stored in the database and displayed via a dropdown bell icon in the storefront header. Only logged-in wholesellers see notifications. Queue is used for performance.

---

## How It Works

### Trigger Flow

1. Admin edits a product and changes its quantity
2. `ProductController@update` saves the product
3. `ProductObserver::updated()` fires and compares old vs new quantity
4. If stock status changed (0→>0 or >0→0), a notification is created
5. Notification is dispatched to all users with `role_id = 3` (wholesellers) via Laravel's queue
6. Storefront users see the notification in their inbox dropdown

### What Counts as a Stock Change

- **In Stock**: old quantity > 0 and new quantity > 0 — no notification. Only 0→>0 triggers "In Stock".
- **Out of Stock**: old quantity > 0 and new quantity == 0 — triggers "Out of Stock".
- **No change**: old == new — no notification.

---

## Database

### `notifications` Table

Laravel's standard notifications table with these columns:

- `id` (uuid, primary key)
- `type` (string — notification class name)
- `notifiable_type` + `notifiable_id` (polymorphic — references the user)
- `data` (JSON — product info, status, message, link)
- `read_at` (nullable timestamp)
- `created_at` / `updated_at`

Indexes on `(type, created_at)` and `(notifiable_type, notifiable_id)`.

---

## Backend Components

### 1. Notification Class — `StockStatusChanged`

- Lives in `app/Notifications/`
- Implements `ShouldQueue` (queued, not synchronous)
- Constructor receives the Product and a status string (`in_stock` or `out_of_stock`)
- Serializes to database with:
  - `product_id`, `product_title`, `product_slug`, `product_image`
  - `status` — `in_stock` or `out_of_stock`
  - `message` — human-readable sentence
  - `link` — product URL
- Delivery channel: `database` only

### 2. Model Observer — `ProductObserver`

- Lives in `app/Observers/`
- Hooks into the `updated` event on `Product`
- Compares `getOriginal('quantity')` vs current `quantity`
- If status changed, queries all `User` where `role_id = 3` and sends the notification
- Registered in `AppServiceProvider::boot()`

### 3. Notification Controller

- Lives in `app/Http/Controllers/StoreFront/`
- `index()` — returns latest 10 notifications for the authenticated user (newest first) plus unread count
- `markAllRead()` — marks all unread notifications as read
- Both routes require authentication

### 4. Routes

Added to `routes/frontend.php` under auth middleware:

- `GET /notifications` — fetch notifications
- `POST /notifications/read` — mark all as read

---

## Frontend Components

### 1. Composable — `useNotifications.js`

- Manages state: notifications array, unread count, loading, open/close
- `fetchNotifications()` — calls the GET endpoint
- `markAllRead()` — calls the POST endpoint, updates local state
- `toggle()` — opens dropdown, fetches fresh data, auto-marks as read if there are unread items

### 2. Component — `NotificationDropdown.vue`

- Bell icon with red badge showing unread count
- Click toggles a dropdown panel
- Panel shows:
  - Header with "Notifications" title and "Mark all read" button
  - List of up to 10 notifications, each with:
    - Status icon (green circle for in-stock, red for out-of-stock)
    - Product thumbnail image
    - Notification message
    - Relative time (e.g., "2 hours ago")
  - Each notification links to the product page
  - Empty state when no notifications exist
- Closes on outside click
- Only renders for authenticated users

### 3. Header Integration

- `NotificationDropdown` is added to the storefront header
- Placed before the user menu / wishlist area
- Only visible when `auth.user` exists

---

## Files to Create

| File | Purpose |
|------|---------|
| `database/migrations/xxxx_create_notifications_table.php` | Notifications table |
| `app/Notifications/StockStatusChanged.php` | Notification class |
| `app/Observers/ProductObserver.php` | Detects quantity changes |
| `app/Http/Controllers/StoreFront/NotificationController.php` | Returns notifications |
| `resources/js/composables/useNotifications.js` | Frontend state management |
| `resources/js/Components/StoreFront/NotificationDropdown.vue` | Bell + dropdown UI |

## Files to Edit

| File | Change |
|------|--------|
| `app/Providers/AppServiceProvider.php` | Register ProductObserver |
| `routes/frontend.php` | Add notification routes |
| `resources/js/Layouts/Frontend/Header.vue` | Add NotificationDropdown |

---

## Key Decisions

- **All wholesalers notified** — every user with `role_id = 3` gets the notification
- **Database driver only** — no broadcasting/WebSocket needed, simple and reliable
- **Queue-based** — notifications dispatched via `ShouldQueue` for non-blocking performance
- **Auto-mark on open** — clicking the bell icon marks all notifications as read
- **10 notification limit** in dropdown — "View All" can be added later if needed
