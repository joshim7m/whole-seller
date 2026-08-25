<script setup>
import { ref } from 'vue'
import { Head, Link, usePage } from '@inertiajs/vue3'
import FrontendHeader from './Header.vue'
import FrontendFooter from './Footer.vue'
import CartDrawer from '@/Components/CartDrawer.vue'
import QuickViewModal from '@/Components/StoreFront/QuickViewModal.vue'
import SearchOverlay from '@/Components/StoreFront/SearchOverlay.vue'
import { useCart } from '@/composables/useCart'
import { useWishlist } from '@/composables/useWishlist'
import { computed } from 'vue'

const page = usePage()
const settings = page.props.settings || {}
const auth = page.props.auth

const { openDrawer, count } = useCart()
const wishlist = useWishlist()
wishlist.load()
const wishlistCount = computed(() => wishlist.ids.value.length)

const mobileOpen = ref(false)
const searchOpen = ref(false)
</script>

<template>
    <Head>
        <title>{{ settings.company_name || 'Store' }}</title>
        <meta name="description" :content="settings.company_description || ''" />
        <link v-if="settings.company_favicon" rel="icon" type="image/x-icon" :href="'/' + settings.company_favicon" />
    </Head>

    <div class="min-h-screen flex flex-col bg-gray-50 dark:bg-gray-950">
        <Teleport to="body">
            <div v-show="mobileOpen" class="fixed inset-0 z-50 bg-black/40" @click="mobileOpen = false"></div>
            <div v-show="mobileOpen" class="fixed inset-y-0 left-0 z-50 w-80 max-w-[85vw] bg-gradient-to-b from-orange-50 via-rose-50 to-indigo-100 dark:from-gray-900 dark:via-gray-900 dark:to-gray-950 shadow-2xl overflow-y-auto">
                <div class="absolute inset-x-0 top-0 h-[3px] bg-gradient-to-r from-[#D9531E] via-amber-400 to-emerald-400"></div>
                <div class="relative flex items-center justify-between px-4 h-16">
                    <div class="flex items-center gap-2.5 min-w-0">
                        <img v-if="settings.company_logo" :src="`/${settings.company_logo}`" :alt="settings.company_name || 'Store'" class="h-8 w-auto">
                        <span v-else class="font-bold text-lg text-gray-900 dark:text-white truncate">{{ settings.company_name || 'Store' }}</span>
                    </div>
                    <button @click="mobileOpen = false" class="w-8 h-8 rounded-full bg-white/80 dark:bg-gray-800 text-gray-500 dark:text-gray-300 hover:text-[#D9531E] dark:hover:text-orange-400 flex items-center justify-center shadow-sm transition" aria-label="Close menu">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <nav class="px-3 py-3 space-y-1">
                    <Link :href="route('home')" class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-white/90 dark:hover:bg-gray-800 transition" @click="mobileOpen = false">
                        <span class="w-8 h-8 rounded-lg bg-orange-100 dark:bg-orange-500/15 text-[#D9531E] dark:text-orange-400 flex items-center justify-center shrink-0 transition group-hover:scale-105">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        </span>
                        Home
                    </Link>
                    <Link :href="route('products.index')" class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-white/90 dark:hover:bg-gray-800 transition" @click="mobileOpen = false">
                        <span class="w-8 h-8 rounded-lg bg-emerald-100 dark:bg-emerald-500/15 text-emerald-600 dark:text-emerald-400 flex items-center justify-center shrink-0 transition group-hover:scale-105">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007z"/></svg>
                        </span>
                        All Products
                    </Link>
                    <Link :href="route('products.new-arrivals')" class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-white/90 dark:hover:bg-gray-800 transition" @click="mobileOpen = false">
                        <span class="w-8 h-8 rounded-lg bg-sky-100 dark:bg-sky-500/15 text-sky-600 dark:text-sky-400 flex items-center justify-center shrink-0 transition group-hover:scale-105">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456z"/></svg>
                        </span>
                        New Arrivals
                    </Link>
                    <Link :href="route('products.hot-sale')" class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-bold text-red-600 dark:text-red-400 hover:bg-red-50/80 dark:hover:bg-red-900/20 transition" @click="mobileOpen = false">
                        <span class="w-8 h-8 rounded-lg bg-red-100 dark:bg-red-500/15 text-red-600 dark:text-red-400 flex items-center justify-center shrink-0 transition group-hover:scale-105">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 18a3.75 3.75 0 00.495-7.467 5.99 5.99 0 00-1.925 3.546 5.974 5.974 0 01-2.133-1A3.75 3.75 0 0012 18z"/></svg>
                        </span>
                        Hot Sale
                    </Link>
                    
                    <Link :href="route('categories.index')" class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-white/90 dark:hover:bg-gray-800 transition" @click="mobileOpen = false">
                        <span class="w-8 h-8 rounded-lg bg-violet-100 dark:bg-violet-500/15 text-violet-600 dark:text-violet-400 flex items-center justify-center shrink-0 transition group-hover:scale-105">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                        </span>
                        Categories
                    </Link>
                    
                    <div class="mx-1 h-px bg-gray-200/80 dark:bg-gray-700"></div>
                    <Link :href="route('wishlist.index')" class="group flex items-center justify-between gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-white/90 dark:hover:bg-gray-800 transition" @click="mobileOpen = false">
                        <span class="flex items-center gap-3">
                            <span class="w-8 h-8 rounded-lg bg-rose-100 dark:bg-rose-500/15 text-rose-600 dark:text-rose-400 flex items-center justify-center shrink-0 transition group-hover:scale-105">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/></svg>
                            </span>
                            Wishlist
                        </span>
                        <span v-if="wishlistCount" class="flex items-center justify-center rounded-full bg-red-500 text-white text-[10px] font-bold leading-none min-w-[18px] h-[18px] px-1">{{ wishlistCount }}</span>
                    </Link>
                    <button type="button" class="group flex items-center justify-between gap-3 w-full px-3 py-2.5 rounded-xl text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-white/90 dark:hover:bg-gray-800 transition" @click="mobileOpen = false; openDrawer()">
                        <span class="flex items-center gap-3">
                            <span class="w-8 h-8 rounded-lg bg-blue-100 dark:bg-blue-500/15 text-blue-600 dark:text-blue-400 flex items-center justify-center shrink-0 transition group-hover:scale-105">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                            </span>
                            Cart
                        </span>
                        <span v-if="count" class="flex items-center justify-center rounded-full bg-blue-600 text-white text-[10px] font-bold leading-none min-w-[18px] h-[18px] px-1">{{ count }}</span>
                    </button>
                    
                </nav>
                <div class="px-3 pb-4 space-y-1">
                    <div class="mx-1 h-px bg-gray-200/80 dark:bg-gray-700"></div>
                    <template v-if="auth?.user">
                        <Link :href="route('profile')" class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-white/90 dark:hover:bg-gray-800 transition" @click="mobileOpen = false">
                            <span class="w-8 h-8 rounded-lg bg-indigo-100 dark:bg-indigo-500/15 text-indigo-600 dark:text-indigo-400 flex items-center justify-center shrink-0 transition group-hover:scale-105">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </span>
                            Profile
                        </Link>
                        <Link :href="route('orders.index')" class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-white/90 dark:hover:bg-gray-800 transition" @click="mobileOpen = false">
                            <span class="w-8 h-8 rounded-lg bg-cyan-100 dark:bg-cyan-500/15 text-cyan-600 dark:text-cyan-400 flex items-center justify-center shrink-0 transition group-hover:scale-105">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                            </span>
                            Orders
                        </Link>
                        <Link :href="route('logout')" method="post" as="button" class="group flex items-center gap-3 w-full text-left px-3 py-2.5 rounded-xl text-sm font-medium text-red-600 dark:text-red-400 hover:bg-red-50/80 dark:hover:bg-red-900/20 transition">
                            <span class="w-8 h-8 rounded-lg bg-red-100 dark:bg-red-500/15 text-red-600 dark:text-red-400 flex items-center justify-center shrink-0 transition group-hover:scale-105">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                            </span>
                            Logout
                        </Link>
                    </template>
                    <template v-else>
                        <Link :href="route('login')" class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-white/90 dark:hover:bg-gray-800 transition" @click="mobileOpen = false">
                            <span class="w-8 h-8 rounded-lg bg-indigo-100 dark:bg-indigo-500/15 text-indigo-600 dark:text-indigo-400 flex items-center justify-center shrink-0 transition group-hover:scale-105">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </span>
                            Login
                        </Link>
                        <Link :href="route('register')" class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-white/90 dark:hover:bg-gray-800 transition" @click="mobileOpen = false">
                            <span class="w-8 h-8 rounded-lg bg-emerald-100 dark:bg-emerald-500/15 text-emerald-600 dark:text-emerald-400 flex items-center justify-center shrink-0 transition group-hover:scale-105">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM3 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 019.374 21c-2.331 0-4.512-.645-6.374-1.766z"/></svg>
                            </span>
                            Register
                        </Link>
                    </template>
                </div>
            </div>

            <CartDrawer />

            <QuickViewModal />

            <SearchOverlay :open="searchOpen" @close="searchOpen = false" />
        </Teleport>

        <FrontendHeader @open-search="searchOpen = true" @open-cart="openDrawer" @open-mobile="mobileOpen = true" />

        <main class="flex-1 max-w-7xl w-full mx-auto px-4 md:px-6 py-6 md:py-8">
            <div v-if="$page.props.flash?.success" class="mb-4 px-4 py-3 rounded-lg bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-300 text-sm font-inter">{{ $page.props.flash.success }}</div>
            <div v-if="$page.props.flash?.error" class="mb-4 px-4 py-3 rounded-lg bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-300 text-sm font-inter">{{ $page.props.flash.error }}</div>
            <slot />
        </main>

        <FrontendFooter />

        <a
            v-if="settings.whatsapp_number"
            :href="`https://wa.me/${settings.whatsapp_number.replace(/[^0-9]/g, '')}`"
            target="_blank"
            rel="noopener noreferrer"
            class="fixed bottom-20 right-4 md:bottom-6 z-40 flex h-14 w-14 items-center justify-center rounded-full bg-[#25D366] text-white shadow-lg transition hover:scale-110 hover:shadow-xl"
            aria-label="Chat on WhatsApp"
        >
            <svg class="h-7 w-7" viewBox="0 0 24 24" fill="currentColor">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
            </svg>
        </a>
    </div>
</template>
