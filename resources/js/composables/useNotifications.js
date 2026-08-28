import { ref } from 'vue'
import axios from 'axios'

const notifications = ref([])
const unreadCount = ref(0)
const loading = ref(false)
const open = ref(false)
let fetched = false

export function useNotifications() {
    async function fetchNotifications() {
        loading.value = true
        try {
            const { data } = await axios.get(route('notifications.index'))
            notifications.value = data.notifications
            unreadCount.value = data.unread_count
            fetched = true
        } catch (e) {
            console.error('Failed to fetch notifications', e)
        } finally {
            loading.value = false
        }
    }

    async function markAllRead() {
        try {
            await axios.post(route('notifications.markRead'))
            unreadCount.value = 0
            notifications.value = notifications.value.map((n) => ({
                ...n,
                read_at: new Date().toISOString(),
            }))
        } catch (e) {
            console.error('Failed to mark notifications as read', e)
        }
    }

    function toggle() {
        open.value = !open.value
        if (open.value) {
            fetchNotifications().then(() => {
                if (unreadCount.value > 0) {
                    markAllRead()
                }
            })
        }
    }

    function close() {
        open.value = false
    }

    return {
        notifications,
        unreadCount,
        loading,
        open,
        fetchNotifications,
        markAllRead,
        toggle,
        close,
    }
}
