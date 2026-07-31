<script setup>
import { Link } from '@inertiajs/vue3'
import { ref } from 'vue'

defineEmits(['close-sidebar'])

defineProps({
    settings: { type: Object, default: () => ({}) },
    sidebarOpen: { type: Boolean, default: false }
})

const settingsOpen = ref(route().current('admin.settings.*'))

const flatLinks = [
    { label: 'Dashboard', route: 'admin.dashboard' },
    { label: 'Products', route: 'admin.products.index' },
    { label: 'Categories', route: 'admin.categories.index' },
    { label: 'Orders', route: 'admin.orders.index' },
    { label: 'Admins', route: 'admin.users.index' },
    { label: 'Sellers', route: 'admin.sellers.index' },
    { label: 'Customers', route: 'admin.users.customers' },
    { label: 'Roles', route: 'admin.roles.index' },
]

const navItems = [
    {
        section: 'Main',
        items: [
            { label: 'Dashboard', route: 'admin.dashboard', icon: 'M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z' }
        ]
    },
    {
        section: 'Products',
        items: [
            { label: 'Products', route: 'admin.products.index', pattern: 'admin.products.*', icon: 'M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z' },
            { label: 'Categories', route: 'admin.categories.index', pattern: 'admin.categories.*', icon: 'M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3zM6 6h.008v.008H6V6z' }
        ]
    },
    {
        section: 'Orders',
        items: [
            { label: 'Orders', route: 'admin.orders.index', pattern: 'admin.orders.*', icon: 'M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z' }
        ]
    },
    {
        section: 'Users',
        items: [
            { label: 'Admins', route: 'admin.users.index', pattern: 'admin.users.*', exclude: 'admin.users.customers', icon: 'M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z' },
            { label: 'Sellers', route: 'admin.sellers.index', pattern: 'admin.sellers.*', icon: 'M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z' },
            { label: 'Customers', route: 'admin.users.customers', pattern: 'admin.users.customers*', icon: 'M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z' },
            { label: 'Roles', route: 'admin.roles.index', pattern: 'admin.roles.*', icon: 'M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z' }
        ]
    }
]

const settingsSubItems = [
    { label: 'Company Info', route: 'admin.settings.company', pattern: 'admin.settings.company', icon: 'M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21' },
    { label: 'Instagram', route: 'admin.instagram-images.index', pattern: 'admin.instagram-images.*', icon: 'M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316zM16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0z' },
    { label: 'Social Links', route: 'admin.social-media.index', pattern: 'admin.social-media.*', icon: 'M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244' }
]

function isActive(item) {
    if (item.exclude && route().current(item.pattern)) return false
    if (item.exclude && route().current(item.exclude)) return false
    return route().current(item.pattern || item.route)
}
</script>

<template>
    <aside class="hidden lg:flex lg:flex-col w-64 bg-white dark:bg-gray-900 border-r border-gray-200 dark:border-gray-800 min-h-screen sticky top-0 h-screen z-30">
        <div class="h-16 flex items-center px-6 border-b border-gray-200 dark:border-gray-800 shrink-0">
            <Link :href="route('home')" class="shrink-0">
                <img v-if="settings.company_logo" :src="`/${settings.company_logo}`" :alt="settings.company_name || 'Eghuri'" class="h-10 w-auto">
                <span v-else class="font-bold text-xl tracking-tight text-gray-900 dark:text-white">{{ settings.company_name || 'Admin' }}</span>
            </Link>
        </div>

        <nav class="flex-1 px-3 py-5 space-y-5 overflow-y-auto sidebar-scrollbar">
            <div v-for="section in navItems" :key="section.section">
                <p class="px-3 mb-1 text-xs font-semibold font-mono uppercase tracking-widest text-gray-400 dark:text-gray-500">{{ section.section }}</p>
                <div class="space-y-0.5">
                    <Link
                        v-for="item in section.items"
                        :key="item.label"
                        :href="route(item.route)"
                        class="relative flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-inter transition"
                        :class="isActive(item) ? 'text-blue-600 font-semibold' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-800'"
                    >
                        <span v-if="isActive(item)" class="absolute left-0 top-1/2 -translate-y-1/2 w-0.5 h-5 bg-blue-600 rounded-full"></span>
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path :d="item.icon" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        {{ item.label }}
                    </Link>
                </div>
            </div>

            <div>
                <p class="px-3 mb-1 text-xs font-semibold font-mono uppercase tracking-widest text-gray-400 dark:text-gray-500">Settings</p>
                <div class="space-y-0.5">
                    <button @click="settingsOpen = !settingsOpen"
                        class="flex items-center justify-between w-full px-3 py-2.5 rounded-lg text-sm font-inter transition"
                        :class="route().current('admin.settings.*') ? 'text-blue-600 font-semibold' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-800'"
                    >
                        <span class="flex items-center gap-3">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281zM15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            Settings
                        </span>
                        <svg v-show="!settingsOpen" class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                        <svg v-show="settingsOpen" class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                    </button>
                    <div v-show="settingsOpen" class="ml-3 space-y-0.5">
                        <Link
                            v-for="sub in settingsSubItems"
                            :key="sub.label"
                            :href="route(sub.route)"
                            class="relative flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-inter transition"
                            :class="route().current(sub.pattern) ? 'text-blue-600 font-semibold' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800'"
                        >
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path :d="sub.icon" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            {{ sub.label }}
                        </Link>
                    </div>
                </div>
            </div>
        </nav>

        <div class="px-3 py-4 border-t border-gray-200 dark:border-gray-800 space-y-1 shrink-0">
            
            <Link :href="route('admin.logout')" method="post" as="button" class="flex items-center gap-3 w-full px-3 py-2.5 rounded-lg text-sm font-inter text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 transition">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/></svg>
                Sign Out
            </Link>
        </div>
    </aside>

    <Teleport to="body">
        <div v-show="sidebarOpen" class="fixed inset-0 z-50 bg-black/40 lg:hidden" @click="$emit('close-sidebar')"></div>

        <div v-show="sidebarOpen"
            class="fixed inset-y-0 left-0 z-50 w-64 bg-white dark:bg-gray-900 shadow-xl lg:hidden overflow-y-auto sidebar-scrollbar"
        >
            <div class="h-16 flex items-center justify-between px-5 border-b border-gray-200 dark:border-gray-800">
                <span class="font-bold text-lg">
                    <span class="text-gray-900 dark:text-white">Admin</span>
                    <span class="text-blue-600">Panel</span>
                </span>
                <button @click="$emit('close-sidebar')" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 p-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <nav class="px-3 py-4 space-y-1">
                <Link v-for="item in flatLinks" :key="item.label" :href="route(item.route)"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-inter transition"
                    :class="route().current(item.route) ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800'"
                >{{ item.label }}</Link>
                <hr class="my-2 border-gray-200 dark:border-gray-800">
                <Link :href="route('home')" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-inter text-gray-500 dark:text-gray-400 hover:text-blue-600 transition">Back to Store</Link>
                <Link :href="route('admin.logout')" method="post" as="button" class="flex items-center gap-3 w-full text-left px-3 py-2.5 rounded-lg text-sm font-inter text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 transition">Sign Out</Link>
            </nav>
        </div>
    </Teleport>
</template>
