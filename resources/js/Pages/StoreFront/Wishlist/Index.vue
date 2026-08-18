<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import ProductCard from '@/Components/StoreFront/ProductCard.vue';
import { useCart } from '@/composables/useCart';
import { useWishlist } from '@/composables/useWishlist';
import FrontEndMaster from '@/Layouts/Frontend/FrontEndMaster.vue';

const props = defineProps({
    products: {
        type: Array,
        default: () => [],
    },
});

const wishlist = useWishlist();
const cart = useCart();

const saved = computed(() =>
    props.products.filter((p) => wishlist.ids.value.includes(p.id)),
);

function imageOf(product) {
    const img = (product.images || [])[0];

    if (!img) {
        return null;
    }

    if (typeof img === 'string') {
        return img;
    }

    return img.image_url || img.image_path || img.url || img.src || null;
}

function priceOf(product) {
    return Number(product.sale_price || product.unit_price || 0);
}

const exporting = ref(false);

async function exportExcel() {
    if (!saved.value.length || exporting.value) {
        return;
    }

    exporting.value = true;

    try {
        const response = await window.axios.post(
            route('wishlist.export'),
            { ids: saved.value.map((p) => p.id) },
            { responseType: 'blob' },
        );

        const url = URL.createObjectURL(response.data);
        const link = document.createElement('a');

        link.href = url;
        link.download = 'wishlist.xlsx';
        document.body.appendChild(link);
        link.click();
        link.remove();
        URL.revokeObjectURL(url);
    } finally {
        exporting.value = false;
    }
}

function addAllToCart() {
    if (!saved.value.length) {
        return;
    }

    saved.value.forEach((p) => {
        cart.addItem({
            product_id: p.id,
            name: p.title,
            sku: p.sku,
            image: imageOf(p),
            price: priceOf(p),
            qty: 1,
            variant_id: null,
            variant_name: null,
        });
    });
    cart.openDrawer();
}

const showClearModal = ref(false);

function confirmClearAll() {
    showClearModal.value = true;
}

function executeClear() {
    showClearModal.value = false;
    wishlist.clear();
}
</script>

<template>
    <Head title="My Wishlist" />

    <FrontEndMaster>
        <div
            class="mb-6 flex flex-col justify-between gap-3 sm:flex-row sm:items-center"
        >
            <div>
                <h1
                    class="text-2xl font-bold text-gray-900 dark:text-white md:text-3xl"
                >
                    My Wishlist
                </h1>
                <p
                    v-if="saved.length"
                    class="mt-1 text-sm text-gray-500 dark:text-gray-400"
                >
                    {{ saved.length }}
                    {{ saved.length === 1 ? 'item' : 'items' }} saved
                </p>
            </div>
            <div v-if="saved.length" class="flex items-center gap-2">
                <button
                    type="button"
                    :disabled="exporting"
                    @click="exportExcel"
                    class="inline-flex items-center gap-2 rounded-full border border-green-600 bg-green-600 px-4 py-2.5 text-sm font-bold text-white transition hover:bg-green-700 disabled:cursor-not-allowed disabled:opacity-60 dark:border-green-500 dark:hover:bg-green-500"
                >
                    <svg
                        class="h-4 w-4"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"
                        />
                    </svg>
                    {{ exporting ? 'Exporting…' : 'Export Excel' }}
                </button>
                <button
                    type="button"
                    @click="addAllToCart"
                    class="inline-flex items-center gap-2 rounded-full border border-[#D9531E] bg-[#0B132A] px-4 py-2.5 text-sm font-bold text-white transition hover:bg-slate-800 dark:border-orange-500 dark:bg-gray-900 dark:hover:bg-gray-800"
                >
                    <svg
                        class="h-4 w-4"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"
                        />
                    </svg>
                    Add All to Cart
                </button>
                <button
                    type="button"
                    @click="confirmClearAll"
                    class="inline-flex items-center gap-2 rounded-full border border-red-200 bg-transparent px-4 py-2.5 text-sm font-semibold text-red-500 transition hover:bg-red-50 dark:border-red-500/40 dark:text-red-400 dark:hover:bg-red-900/20"
                >
                    <svg
                        class="h-4 w-4"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                        />
                    </svg>
                    Clear All
                </button>
            </div>
        </div>

        <div
            v-if="saved.length"
            class="grid grid-cols-1 gap-4 md:grid-cols-2 md:gap-5"
        >
            <ProductCard
                v-for="product in saved"
                :key="product.id"
                :product="product"
            />
        </div>

        <div v-else class="py-20 text-center">
            <svg
                class="mx-auto h-20 w-20 text-gray-300 dark:text-gray-600"
                fill="none"
                stroke="currentColor"
                stroke-width="1.5"
                viewBox="0 0 24 24"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"
                />
            </svg>
            <h2 class="mt-4 text-lg font-bold text-gray-900 dark:text-white">
                Your wishlist is empty
            </h2>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Tap the heart on any product to save it here.
            </p>
            <Link
                :href="route('products.index')"
                class="mt-6 inline-block rounded-full border border-[#D9531E] bg-[#0B132A] px-6 py-3 text-sm font-bold text-white transition hover:bg-slate-800 dark:border-orange-500 dark:bg-gray-900 dark:hover:bg-gray-800"
            >
                Explore Products
            </Link>
        </div>

        <Teleport to="body">
            <Transition
                enter-active-class="duration-200 ease-out"
                enter-from-class="opacity-0"
                enter-to-class="opacity-100"
                leave-active-class="duration-150 ease-in"
                leave-from-class="opacity-100"
                leave-to-class="opacity-0"
            >
                <div v-if="showClearModal" class="fixed inset-0 z-50 flex items-center justify-center p-4" @keydown.escape.window="showClearModal = false">
                    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" @click="showClearModal = false"></div>
                    <div class="relative w-full max-w-sm rounded-2xl bg-white p-6 shadow-2xl dark:bg-gray-900">
                        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-red-100 dark:bg-red-500/15 mx-auto">
                            <svg class="h-6 w-6 text-red-500 dark:text-red-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                            </svg>
                        </div>
                        <h3 class="mt-4 text-center text-lg font-bold text-gray-900 dark:text-white">Clear Wishlist?</h3>
                        <p class="mt-2 text-center text-sm text-gray-500 dark:text-gray-400">This will remove all {{ saved.length }} {{ saved.length === 1 ? 'item' : 'items' }} from your wishlist. This action cannot be undone.</p>
                        <div class="mt-6 flex gap-3">
                            <button
                                @click="showClearModal = false"
                                class="flex-1 rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700"
                            >
                                Cancel
                            </button>
                            <button
                                @click="executeClear"
                                class="flex-1 rounded-xl bg-red-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-red-700"
                            >
                                Yes, Clear All
                            </button>
                        </div>
                    </div>
                </div>
            </Transition>
        </Teleport>
    </FrontEndMaster>
</template>
