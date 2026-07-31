<script setup>
import { Head, Link, router } from '@inertiajs/vue3'
import FrontEndMaster from '@/Layouts/Frontend/FrontEndMaster.vue'
import ProductCard from '@/Components/StoreFront/ProductCard.vue'

const props = defineProps({
    products: { type: Object, default: () => ({ data: [], total: 0 }) }
})

const urlParams = new URL(window.location.href).searchParams

function changeSort(event) {
    const params = new URLSearchParams(window.location.search)
    params.set('sort', event.target.value)
    router.get(window.location.pathname + '?' + params.toString(), {}, { preserveScroll: true, preserveState: true })
}
</script>

<template>
    <Head title="New Arrivals" />

    <FrontEndMaster>
        <nav class="text-sm text-gray-500 dark:text-gray-400 mb-4 flex items-center gap-1.5">
            <Link :href="route('home')" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Home</Link>
            <svg class="w-3 h-3 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            <span class="text-gray-800 dark:text-gray-200 font-medium">New Arrivals</span>
        </nav>

        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl md:text-3xl lg:text-4xl font-bold text-gray-800 dark:text-white">New Arrivals</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Check out our latest products.</p>
            </div>
            <p class="text-sm text-gray-400 dark:text-gray-500 shrink-0 ml-4">{{ products.total || 0 }} products</p>
        </div>

        <div class="flex items-center justify-between mb-6">
            <div />
            <select @change="changeSort" class="bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-sm text-gray-700 dark:text-gray-300 focus:outline-none focus:border-blue-600">
                <option value="latest" :selected="urlParams.get('sort') === 'latest' || !urlParams.get('sort')">Sort: Latest</option>
                <option value="price_asc" :selected="urlParams.get('sort') === 'price_asc'">Price: Low to High</option>
                <option value="price_desc" :selected="urlParams.get('sort') === 'price_desc'">Price: High to Low</option>
                <option value="name_asc" :selected="urlParams.get('sort') === 'name_asc'">Name: A-Z</option>
                <option value="name_desc" :selected="urlParams.get('sort') === 'name_desc'">Name: Z-A</option>
            </select>
        </div>

        <div v-if="products.data && products.data.length" class="grid grid-cols-2 md:grid-cols-4 xl:grid-cols-6 gap-3 md:gap-3">
            <ProductCard v-for="product in products.data" :key="product.id" :product="product" compact />
        </div>
        <div v-else class="text-center py-20">
            <svg class="w-16 h-16 mx-auto text-gray-200 dark:text-gray-700 mb-4" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
                <path d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
            </svg>
            <p class="text-gray-400 dark:text-gray-500 text-sm">No new arrivals yet.</p>
        </div>

        <div v-if="products.links && products.links.length > 3" class="mt-8 flex justify-center gap-1">
            <Link v-for="(link, i) in products.links" :key="i" :href="link.url || '#'" v-html="link.label" class="px-3 py-1.5 text-sm rounded-lg transition"
                :class="link.active ? 'bg-blue-600 text-white' : 'bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700'"
                :preserve-scroll="true"
            />
        </div>
    </FrontEndMaster>
</template>
