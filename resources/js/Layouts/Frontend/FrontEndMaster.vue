<script setup>
import { ref } from 'vue'
import { Head, Link, usePage } from '@inertiajs/vue3'
import FrontendHeader from './Header.vue'
import FrontendFooter from './Footer.vue'
import CartDrawer from '@/Components/CartDrawer.vue'

const page = usePage()
const settings = page.props.settings || {}
const auth = page.props.auth

const mobileOpen = ref(false)
const cartOpen = ref(false)
const searchOpen = ref(false)

const waNumber = settings.company_mobile || '01779967919'
const waClean = waNumber.replace(/[^0-9]/g, '')
const waHref = 'https://wa.me/' + (waClean.startsWith('0') ? '88' + waClean : waClean)
</script>

<template>
    <Head>
        <title>{{ settings.company_name || 'Store' }}</title>
        <meta name="description" :content="settings.company_description || ''" />
        <link v-if="settings.company_favicon" rel="icon" type="image/x-icon" :href="'/' + settings.company_favicon" />
    </Head>

    <div class="min-h-screen flex flex-col bg-gray-50 dark:bg-gray-950">
        <Teleport to="body">
            <div v-show="mobileOpen" class="fixed inset-0 z-50 bg-black/40 md:hidden" @click="mobileOpen = false"></div>
            <div v-show="mobileOpen" class="fixed inset-y-0 left-0 z-50 w-72 bg-white dark:bg-gray-900 shadow-xl md:hidden overflow-y-auto">
                <div class="flex items-center justify-between px-4 h-14 border-b border-gray-200 dark:border-gray-800">
                    <span class="font-bold text-lg text-gray-900 dark:text-white">{{ settings.company_name || 'Store' }}</span>
                    <button @click="mobileOpen = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 p-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <nav class="px-3 py-4 space-y-1">
                    <Link :href="route('home')" class="block px-3 py-2.5 rounded-lg text-sm font-inter text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition" @click="mobileOpen = false">Home</Link>
                    <Link :href="route('products.index')" class="block px-3 py-2.5 rounded-lg text-sm font-inter text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition" @click="mobileOpen = false">All Products</Link>
                    <Link :href="route('products.new-arrivals')" class="block px-3 py-2.5 rounded-lg text-sm font-inter text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition" @click="mobileOpen = false">New Arrivals</Link>
                    <Link :href="route('categories.index')" class="block px-3 py-2.5 rounded-lg text-sm font-inter text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition" @click="mobileOpen = false">Categories</Link>
                    <Link :href="route('products.hot-sale')" class="block px-3 py-2.5 rounded-lg text-sm font-inter text-red-500 dark:text-red-400 font-semibold hover:bg-red-50 dark:hover:bg-red-900/20 transition" @click="mobileOpen = false">Hot Sale</Link>
                    <hr class="my-2 border-gray-200 dark:border-gray-700">
                    <template v-if="auth?.user">
                        <Link :href="route('profile')" class="block px-3 py-2.5 rounded-lg text-sm font-inter text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition" @click="mobileOpen = false">Profile</Link>
                        <Link :href="route('orders.index')" class="block px-3 py-2.5 rounded-lg text-sm font-inter text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition" @click="mobileOpen = false">Orders</Link>
                        <Link :href="route('logout')" method="post" as="button" class="block w-full text-left px-3 py-2.5 rounded-lg text-sm font-inter text-red-500 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition">Logout</Link>
                    </template>
                    <template v-else>
                        <Link :href="route('login')" class="block px-3 py-2.5 rounded-lg text-sm font-inter text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition" @click="mobileOpen = false">Login</Link>
                        <Link :href="route('register')" class="block px-3 py-2.5 rounded-lg text-sm font-inter text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition" @click="mobileOpen = false">Register</Link>
                    </template>
                </nav>
            </div>

            <CartDrawer :open="cartOpen" @close="cartOpen = false" />

            <div v-show="searchOpen" class="fixed inset-0 z-50 bg-black/60" @click="searchOpen = false"></div>
            <div v-show="searchOpen" class="fixed inset-x-0 top-0 z-50 bg-white dark:bg-gray-900 shadow-lg p-4">
                <div class="max-w-2xl mx-auto">
                    <div class="flex items-center gap-2">
                        <input type="text" placeholder="Search products..." class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                        <button @click="searchOpen = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 p-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                </div>
            </div>
        </Teleport>

        <FrontendHeader @open-search="searchOpen = true" @open-cart="cartOpen = true" @open-mobile="mobileOpen = true" />

        <main class="flex-1 max-w-7xl w-full mx-auto px-4 md:px-6 py-6 md:py-8">
            <div v-if="$page.props.flash?.success" class="mb-4 px-4 py-3 rounded-lg bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-300 text-sm font-inter">{{ $page.props.flash.success }}</div>
            <div v-if="$page.props.flash?.error" class="mb-4 px-4 py-3 rounded-lg bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-300 text-sm font-inter">{{ $page.props.flash.error }}</div>
            <slot />
        </main>

        <FrontendFooter />

        <a :href="waHref" target="_blank" rel="noopener noreferrer" aria-label="Chat on WhatsApp"
           class="fixed bottom-20 md:bottom-6 right-6 z-40 flex items-center justify-center w-14 h-14 bg-green-500 text-white rounded-full shadow-lg hover:bg-green-600 hover:scale-105 active:scale-95 transition-all duration-200">
            <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
            </svg>
        </a>
    </div>
</template>
