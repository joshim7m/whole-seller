<script setup>
import { Head, Link } from '@inertiajs/vue3'
import FrontEndMaster from '@/Layouts/Frontend/FrontEndMaster.vue'
import ProductCard from '@/Components/StoreFront/ProductCard.vue'

defineProps({
    products: { type: Array, default: () => [] }
})
</script>

<template>
    <Head title="Hot Sale" />

    <FrontEndMaster>
        <nav class="text-sm text-gray-500 dark:text-gray-400 mb-4 flex items-center gap-1.5">
            <Link :href="route('home')" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Home</Link>
            <svg class="w-3 h-3 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            <span class="text-gray-800 dark:text-gray-200 font-medium">Hot Sale</span>
        </nav>

        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl md:text-3xl lg:text-4xl font-bold text-gray-800 dark:text-white">Hot Sale</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Featured deals and trending products.</p>
            </div>
            <p class="text-sm text-gray-400 dark:text-gray-500 shrink-0 ml-4">{{ products.length }} products</p>
        </div>

        <div v-if="products.length" class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-5">
            <ProductCard v-for="product in products" :key="product.id" :product="product" />
        </div>
        <div v-else class="text-center py-20">
            <svg class="w-16 h-16 mx-auto text-gray-200 dark:text-gray-700 mb-4" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
                <path d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
            </svg>
            <p class="text-gray-400 dark:text-gray-500 text-sm">No hot sale products right now.</p>
        </div>
    </FrontEndMaster>
</template>
