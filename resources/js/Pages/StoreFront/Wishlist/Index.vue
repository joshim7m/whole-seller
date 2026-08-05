<script setup>
import { computed, onBeforeUnmount, ref } from 'vue'
import { Head, Link } from '@inertiajs/vue3'
import FrontEndMaster from '@/Layouts/Frontend/FrontEndMaster.vue'
import ProductCard from '@/Components/StoreFront/ProductCard.vue'
import { useWishlist } from '@/composables/useWishlist'
import { useCart } from '@/composables/useCart'

const props = defineProps({
    products: {
        type: Array,
        default: () => [],
    },
})

const wishlist = useWishlist()
const cart = useCart()

const saved = computed(() =>
    props.products.filter((p) => wishlist.ids.value.includes(p.id))
)

function imageOf(product) {
    const img = (product.images || [])[0]
    if (!img) return null
    if (typeof img === 'string') return img
    return img.image_url || img.image_path || img.url || img.src || null
}

function addAllToCart() {
    if (!saved.value.length) return
    saved.value.forEach((p) => {
        cart.addItem({
            product_id: p.id,
            name: p.title,
            sku: p.sku,
            image: imageOf(p),
            price: Number(p.sale_price || p.unit_price || 0),
            qty: 1,
            variant_id: null,
            variant_name: null,
        })
    })
    cart.openDrawer()
}

const confirmClear = ref(false)
let clearTimer = null

function clearAll() {
    if (!confirmClear.value) {
        confirmClear.value = true
        clearTimer = setTimeout(() => { confirmClear.value = false }, 3000)
        return
    }
    confirmClear.value = false
    clearTimeout(clearTimer)
    wishlist.clear()
}

onBeforeUnmount(() => clearTimeout(clearTimer))
</script>

<template>
    <Head title="My Wishlist" />

    <FrontEndMaster>
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white">My Wishlist</h1>
                <p v-if="saved.length" class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    {{ saved.length }} {{ saved.length === 1 ? 'item' : 'items' }} saved
                </p>
            </div>
            <div v-if="saved.length" class="flex items-center gap-2">
                <button
                    type="button"
                    @click="addAllToCart"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-full bg-[#0B132A] dark:bg-gray-900 text-white text-sm font-bold border border-[#D9531E] dark:border-orange-500 hover:bg-slate-800 dark:hover:bg-gray-800 transition"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                    Add All to Cart
                </button>
                <button
                    type="button"
                    @click="clearAll"
                    :class="confirmClear ? 'bg-red-600 border-red-600 text-white' : 'text-red-500 dark:text-red-400 border-red-200 dark:border-red-500/40 hover:bg-red-50 dark:hover:bg-red-900/20'"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-full border bg-transparent text-sm font-semibold transition"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    {{ confirmClear ? 'Click to confirm' : 'Clear All' }}
                </button>
            </div>
        </div>

        <div v-if="saved.length" class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-5">
            <ProductCard v-for="product in saved" :key="product.id" :product="product" />
        </div>

        <div v-else class="text-center py-20">
            <svg class="w-20 h-20 mx-auto text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
            </svg>
            <h2 class="mt-4 text-lg font-bold text-gray-900 dark:text-white">Your wishlist is empty</h2>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Tap the heart on any product to save it here.</p>
            <Link :href="route('products.index')" class="inline-block mt-6 px-6 py-3 bg-[#0B132A] dark:bg-gray-900 text-white rounded-full border border-[#D9531E] dark:border-orange-500 text-sm font-bold hover:bg-slate-800 dark:hover:bg-gray-800 transition">
                Explore Products
            </Link>
        </div>
    </FrontEndMaster>
</template>
