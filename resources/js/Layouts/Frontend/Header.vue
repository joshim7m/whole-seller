<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'
import { useCart } from '@/composables/useCart'

defineEmits(['open-search', 'open-cart', 'open-mobile'])

const { count } = useCart()

const page = usePage()
const settings = page.props.settings || {}
const auth = page.props.auth

const userMenuOpen = ref(false)
const userMenuEl = ref(null)
const isDark = ref(localStorage.getItem('darkMode') === 'true')

function toggleDark() {
    isDark.value = !isDark.value
    localStorage.setItem('darkMode', isDark.value)
    document.documentElement.classList.toggle('dark', isDark.value)
}

onMounted(() => {
    if (isDark.value) {
        document.documentElement.classList.add('dark')
    }
})

function toggleUserMenu() {
    userMenuOpen.value = !userMenuOpen.value
}

function onClickOutside(e) {
    if (userMenuEl.value && !userMenuEl.value.contains(e.target)) {
        userMenuOpen.value = false
    }
}

onMounted(() => document.addEventListener('click', onClickOutside))
onUnmounted(() => document.removeEventListener('click', onClickOutside))
</script>

<template>
    <div>

        <header class="hidden md:block bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800 sticky top-0 z-40">
            <div class="max-w-7xl mx-auto px-6">
                <div class="flex items-center justify-between h-16">
                    <Link :href="route('home')" class="shrink-0">
                        <img v-if="settings.company_logo" :src="`/${settings.company_logo}`" :alt="settings.company_name || 'Store'" class="h-10 w-auto">
                        <span v-else class="font-bold text-2xl tracking-tight text-gray-900 dark:text-white">{{ settings.company_name || 'Store' }}</span>
                    </Link>

                    <nav class="flex items-center gap-1 font-inter text-sm font-medium">
                        <Link :href="route('home')" class="px-3 py-2 text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition" :class="{ 'text-blue-600 dark:text-blue-400': route().current('home') }">Home</Link>
                        <Link :href="route('products.new-arrivals')" class="px-3 py-2 text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition" :class="{ 'text-blue-600 dark:text-blue-400': route().current('products.new-arrivals') }">New Arrivals</Link>
                        <Link :href="route('categories.index')" class="px-3 py-2 text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition" :class="{ 'text-blue-600 dark:text-blue-400': route().current('categories.*') }">Categories</Link>
                        <Link :href="route('products.hot-sale')" class="px-3 py-2 text-red-500 dark:text-red-400 hover:text-red-600 dark:hover:text-red-300 transition font-semibold">Hot Sale</Link>
                    </nav>

                    <div class="flex items-center gap-3 shrink-0">
                        <button @click="$emit('open-search')" class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition p-1.5" aria-label="Search">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </button>
                        <button @click="toggleDark" class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition p-1.5" aria-label="Toggle dark mode">
                            <svg v-if="isDark" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                            <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                        </button>
                        <button @click="$emit('open-cart')" class="relative text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition p-1.5" aria-label="Cart">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                            <span v-if="count" class="absolute -top-0.5 -right-0.5 flex items-center justify-center rounded-full bg-blue-600 text-white text-[10px] font-bold leading-none min-w-[18px] h-[18px] px-1">{{ count }}</span>
                        </button>
                        <template v-if="auth?.user">
                            <div class="w-px h-5 bg-gray-200 dark:bg-gray-700"></div>
                            <div ref="userMenuEl" class="relative">
                                <button @click="toggleUserMenu" class="w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900/40 flex items-center justify-center text-blue-600 dark:text-blue-400 font-bold text-sm hover:bg-blue-200 dark:hover:bg-blue-900/60 transition" aria-label="User menu">
                                    {{ (auth.user.name || 'U').charAt(0).toUpperCase() }}
                                </button>
                                <div v-show="userMenuOpen" class="absolute right-0 top-full mt-2 w-48 bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-700 shadow-lg py-2 z-50">
                                    <Link :href="route('profile')" class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                        Profile
                                    </Link>
                                    <Link :href="route('orders.index')" class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                                        Orders
                                    </Link>
                                    <hr class="my-1.5 border-gray-100 dark:border-gray-700">
                                    <Link :href="route('logout')" method="post" as="button" class="flex items-center gap-2.5 w-full text-left px-4 py-2.5 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                        Logout
                                    </Link>
                                </div>
                            </div>
                        </template>
                        <template v-else>
                            <Link :href="route('login')" class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition text-sm font-inter font-medium">Log in</Link>
                            <div class="w-px h-5 bg-gray-200 dark:bg-gray-700"></div>
                            <Link :href="route('register')" class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition text-sm font-inter font-medium">Register</Link>
                        </template>
                    </div>
                </div>
            </div>
        </header>

        <div class="md:hidden flex items-center justify-between bg-white dark:bg-gray-900 px-4 h-14 border-b border-gray-200 dark:border-gray-800 sticky top-0 z-40">
            <button @click="$emit('open-mobile')" class="text-gray-700 dark:text-gray-300 p-1.5" aria-label="Open menu">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
            <Link :href="route('home')">
                <img v-if="settings.company_logo" :src="`/${settings.company_logo}`" :alt="settings.company_name || 'Store'" class="h-8 w-auto">
                <span v-else class="font-bold text-xl text-gray-900 dark:text-white">{{ settings.company_name || 'Store' }}</span>
            </Link>
            <div class="flex items-center gap-2">
                <button @click="toggleDark" class="text-gray-600 dark:text-gray-400 p-1.5" aria-label="Toggle dark mode">
                    <svg v-if="isDark" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                </button>
                <button @click="$emit('open-search')" class="text-gray-600 dark:text-gray-400 p-1.5" aria-label="Search">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </button>
                <button @click="$emit('open-cart')" class="relative text-gray-600 dark:text-gray-400 p-1.5" aria-label="Open cart">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                    <span v-if="count" class="absolute -top-0.5 -right-0.5 w-4.5 h-4.5 flex items-center justify-center rounded-full bg-blue-600 text-white text-[10px] font-bold leading-none min-w-[18px] h-[18px] px-1">{{ count }}</span>
                </button>
            </div>
        </div>
    </div>
</template>
