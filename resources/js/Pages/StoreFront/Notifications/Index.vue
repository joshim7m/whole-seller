<script setup>
import { Head, Link } from '@inertiajs/vue3'
import FrontEndMaster from '@/Layouts/Frontend/FrontEndMaster.vue'

defineProps({
    notifications: { type: Object, default: () => ({}) },
})

function timeAgo(date) {
    if (!date) return ''
    const seconds = Math.floor((new Date() - new Date(date)) / 1000)
    if (seconds < 60) return 'just now'
    const minutes = Math.floor(seconds / 60)
    if (minutes < 60) return `${minutes}m ago`
    const hours = Math.floor(minutes / 60)
    if (hours < 24) return `${hours}h ago`
    const days = Math.floor(hours / 24)
    if (days < 30) return `${days}d ago`
    return new Date(date).toLocaleDateString()
}
</script>

<template>
    <Head title="Notifications" />

    <FrontEndMaster>
        <nav class="mb-4 flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400">
            <Link :href="route('home')" class="transition hover:text-[#D9531E] dark:hover:text-orange-400">Home</Link>
            <svg class="h-3 w-3 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
            <span class="font-medium text-gray-800 dark:text-gray-200">Notifications</span>
        </nav>

        <div class="mx-auto max-w-3xl">
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800 dark:text-white md:text-3xl">Notifications</h1>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Your stock update alerts.</p>
                </div>
            </div>

            <div v-if="notifications.data && notifications.data.length" class="space-y-2">
                <Link
                    v-for="n in notifications.data"
                    :key="n.id"
                    :href="n.data.link || '#'"
                    class="flex items-start gap-4 rounded-2xl border border-gray-200 bg-white p-4 transition hover:-translate-y-0.5 hover:shadow-md dark:border-gray-700 dark:bg-gray-800 dark:hover:border-gray-600"
                    :class="{ 'border-l-4 border-l-blue-500 dark:border-l-blue-400': !n.read_at }"
                >
                    <div class="relative mt-0.5 h-12 w-12 shrink-0 overflow-hidden rounded-xl bg-gray-100 dark:bg-gray-700">
                        <img
                            v-if="n.data.product_image"
                            :src="n.data.product_image"
                            :alt="n.data.product_title"
                            class="h-full w-full object-cover"
                        />
                        <span
                            v-else
                            class="flex h-full w-full items-center justify-center"
                            :class="n.data.status === 'in_stock'
                                ? 'bg-green-100 dark:bg-green-900/30'
                                : 'bg-red-100 dark:bg-red-900/30'"
                        >
                            <svg
                                v-if="n.data.status === 'in_stock'"
                                class="h-5 w-5 text-green-600 dark:text-green-400"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                            >
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <svg
                                v-else
                                class="h-5 w-5 text-red-600 dark:text-red-400"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                            >
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                            </svg>
                        </span>
                        <span
                            class="absolute bottom-0 right-0 flex h-5 w-5 items-center justify-center rounded-full border border-white dark:border-gray-800"
                            :class="n.data.status === 'in_stock'
                                ? 'bg-green-500'
                                : 'bg-red-500'"
                        >
                            <svg
                                v-if="n.data.status === 'in_stock'"
                                class="h-3 w-3 text-white"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2.5"
                                viewBox="0 0 24 24"
                            >
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                            </svg>
                            <svg
                                v-else
                                class="h-3 w-3 text-white"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2.5"
                                viewBox="0 0 24 24"
                            >
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </span>
                    </div>

                    <div class="min-w-0 flex-1">
                        <p class="truncate text-sm font-semibold text-gray-800 dark:text-gray-200">
                            {{ n.data.product_title }}
                        </p>
                        <p
                            class="mt-0.5 text-xs font-bold"
                            :class="n.data.status === 'in_stock'
                                ? 'text-green-600 dark:text-green-400'
                                : 'text-red-500 dark:text-red-400'"
                        >
                            {{ n.data.status === 'in_stock' ? 'In Stock' : 'Out of Stock' }}
                        </p>
                        <p class="mt-1 text-xs text-gray-400 dark:text-gray-500">
                            {{ timeAgo(n.created_at) }}
                        </p>
                    </div>

                    <span
                        v-if="!n.read_at"
                        class="mt-2 h-2 w-2 shrink-0 rounded-full bg-blue-500"
                    ></span>
                </Link>
            </div>

            <div v-else class="py-20 text-center">
                <svg class="mx-auto h-14 w-14 text-gray-200 dark:text-gray-700" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                </svg>
                <p class="mt-3 text-sm text-gray-400 dark:text-gray-500">No notifications yet</p>
                <Link :href="route('home')" class="mt-4 inline-block text-sm font-medium text-[#D9531E] transition hover:text-[#c24a17] dark:text-orange-400">
                    Browse Products
                </Link>
            </div>

            <div v-if="notifications.last_page > 1" class="mt-8 flex items-center justify-center gap-1">
                <Link
                    v-for="page in notifications.last_page"
                    :key="page"
                    :href="notifications.path + '?page=' + page"
                    class="flex h-9 w-9 items-center justify-center rounded-lg text-sm font-medium transition"
                    :class="page === notifications.current_page
                        ? 'bg-[#D9531E] text-white shadow-sm'
                        : 'text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-800'"
                >
                    {{ page }}
                </Link>
            </div>
        </div>
    </FrontEndMaster>
</template>
