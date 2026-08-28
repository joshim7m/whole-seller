<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import { Link } from '@inertiajs/vue3'
import { useNotifications } from '@/composables/useNotifications'

const { notifications, unreadCount, loading, open, toggle, close } = useNotifications()

const dropdownEl = ref(null)

function onClickOutside(e) {
    if (dropdownEl.value && !dropdownEl.value.contains(e.target)) {
        close()
    }
}

function timeAgo(date) {
    if (!date) return ''
    const seconds = Math.floor((new Date() - new Date(date)) / 1000)
    if (seconds < 60) return 'just now'
    const minutes = Math.floor(seconds / 60)
    if (minutes < 60) return `${minutes}m ago`
    const hours = Math.floor(minutes / 60)
    if (hours < 24) return `${hours}h ago`
    const days = Math.floor(hours / 24)
    return `${days}d ago`
}

onMounted(() => document.addEventListener('click', onClickOutside))
onUnmounted(() => document.removeEventListener('click', onClickOutside))
</script>

<template>
    <div ref="dropdownEl" class="relative">
        <button
            @click="toggle"
            class="relative p-1.5 text-gray-600 transition hover:text-[#D9531E] dark:text-gray-400 dark:hover:text-orange-400"
            aria-label="Notifications"
        >
            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
            </svg>
            <span
                v-if="unreadCount > 0"
                class="absolute -top-0.5 -right-0.5 flex h-4 min-w-[16px] items-center justify-center rounded-full bg-red-500 px-1 text-[10px] font-bold leading-none text-white"
            >
                {{ unreadCount > 9 ? '9+' : unreadCount }}
            </span>
        </button>

        <Transition
            enter-active-class="transition duration-150 ease-out"
            enter-from-class="scale-95 opacity-0"
            enter-to-class="scale-100 opacity-100"
            leave-active-class="transition duration-100 ease-in"
            leave-from-class="scale-100 opacity-100"
            leave-to-class="scale-95 opacity-0"
        >
            <div
                v-if="open"
                class="absolute right-0 top-full z-50 mt-2 w-80 sm:w-96 rounded-2xl border border-gray-200 bg-white shadow-xl dark:border-gray-700 dark:bg-gray-900 overflow-hidden"
            >
                <div class="flex items-center justify-between border-b border-gray-100 px-4 py-3 dark:border-gray-800">
                    <h3 class="text-sm font-bold text-gray-900 dark:text-white">Notifications</h3>
                    <button
                        v-if="unreadCount > 0"
                        @click.stop="markAllRead"
                        class="text-xs font-medium text-blue-600 transition hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300"
                    >
                        Mark all read
                    </button>
                </div>

                <div class="max-h-80 overflow-y-auto notification-scroll">
                    <div v-if="loading && !notifications.length" class="py-8 text-center">
                        <div class="inline-block h-5 w-5 animate-spin rounded-full border-2 border-gray-300 border-t-blue-600 dark:border-gray-600 dark:border-t-blue-400"></div>
                        <p class="mt-2 text-xs text-gray-400 dark:text-gray-500">Loading...</p>
                    </div>

                    <div v-else-if="!notifications.length" class="py-10 text-center">
                        <svg class="mx-auto h-10 w-10 text-gray-200 dark:text-gray-700" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                        </svg>
                        <p class="mt-2 text-sm text-gray-400 dark:text-gray-500">No notifications yet</p>
                    </div>

                    <div v-else>
                        <Link
                            v-for="n in notifications"
                            :key="n.id"
                            :href="n.data.link || '#'"
                            class="flex items-start gap-3 border-b border-gray-50 px-4 py-3 transition hover:bg-gray-50 dark:border-gray-800 dark:hover:bg-gray-800/50"
                            :class="{ 'bg-blue-50/50 dark:bg-blue-900/10': !n.read_at }"
                            @click="close"
                        >
                            <span
                                class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-full"
                                :class="n.data.status === 'in_stock'
                                    ? 'bg-green-100 dark:bg-green-900/30'
                                    : 'bg-red-100 dark:bg-red-900/30'"
                            >
                                <svg
                                    v-if="n.data.status === 'in_stock'"
                                    class="h-4 w-4 text-green-600 dark:text-green-400"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    viewBox="0 0 24 24"
                                >
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <svg
                                    v-else
                                    class="h-4 w-4 text-red-600 dark:text-red-400"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    viewBox="0 0 24 24"
                                >
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                </svg>
                            </span>

                            <div class="min-w-0 flex-1">
                                <p class="min-w-0 truncate text-sm font-medium text-gray-800 dark:text-gray-200">
                                    {{ n.data.product_title }}
                                </p>
                                <p
                                    class="mt-0.5 text-xs font-semibold"
                                    :class="n.data.status === 'in_stock'
                                        ? 'text-green-600 dark:text-green-400'
                                        : 'text-red-500 dark:text-red-400'"
                                >
                                    {{ n.data.status === 'in_stock' ? 'In Stock' : 'Out of Stock' }}
                                </p>
                                <p class="mt-0.5 text-[11px] text-gray-400 dark:text-gray-500">
                                    {{ timeAgo(n.created_at) }}
                                </p>
                            </div>

                            <span
                                v-if="!n.read_at"
                                class="mt-2 h-2 w-2 shrink-0 rounded-full bg-blue-500"
                            ></span>
                        </Link>
                    </div>
                </div>

                <Link
                    v-if="notifications.length"
                    :href="route('notifications.page')"
                    class="block border-t border-gray-100 px-4 py-2.5 text-center text-xs font-medium text-blue-600 transition hover:bg-gray-50 hover:text-blue-700 dark:border-gray-800 dark:text-blue-400 dark:hover:bg-gray-800/50 dark:hover:text-blue-300"
                    @click="close"
                >
                    View All Notifications
                </Link>
            </div>
        </Transition>
    </div>
</template>

<style scoped>
.notification-scroll::-webkit-scrollbar {
    width: 4px;
}
.notification-scroll::-webkit-scrollbar-track {
    background: transparent;
}
.notification-scroll::-webkit-scrollbar-thumb {
    background: #d1d5db;
    border-radius: 9999px;
}
.notification-scroll::-webkit-scrollbar-thumb:hover {
    background: #9ca3af;
}
:is(.dark) .notification-scroll::-webkit-scrollbar-thumb {
    background: #374151;
}
:is(.dark) .notification-scroll::-webkit-scrollbar-thumb:hover {
    background: #4b5563;
}
</style>
