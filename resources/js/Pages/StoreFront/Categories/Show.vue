<script setup>
import { ref } from 'vue'
import { Head, Link, router } from '@inertiajs/vue3'
import FrontEndMaster from '@/Layouts/Frontend/FrontEndMaster.vue'
import FilterSidebar from '@/Components/StoreFront/FilterSidebar.vue'
import ProductCard from '@/Components/StoreFront/ProductCard.vue'

const props = defineProps({
    category: { type: Object, default: () => ({}) },
    products: { type: Object, default: () => ({ data: [] }) },
    filters: { type: Object, default: () => ({}) }
})

const filterOpen = ref(false)
const urlParams = new URL(window.location.href).searchParams

function changeSort(event) {
    const params = new URLSearchParams(window.location.search)
    params.set('sort', event.target.value)
    router.get(window.location.pathname + '?' + params.toString(), {}, { preserveScroll: true, preserveState: true })
}
</script>

<template>
    <Head :title="category.name || 'Category'" />

    <FrontEndMaster>
        <nav class="text-sm text-gray-500 dark:text-gray-400 mb-4 flex items-center gap-1.5">
            <Link :href="route('home')" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Home</Link>
            <svg class="w-3 h-3 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            <Link :href="route('categories.index')" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Categories</Link>
            <svg class="w-3 h-3 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            <span class="text-gray-800 dark:text-gray-200 font-medium">{{ category.name }}</span>
        </nav>

        <div class="relative rounded-2xl overflow-hidden bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-900 mb-8">
            <div v-if="category.image_url" class="absolute inset-0">
                <img :src="category.image_url" :alt="category.name" class="w-full h-full object-cover opacity-30">
            </div>
            <div class="relative px-6 py-8 md:px-10 md:py-12">
                <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 dark:text-white">{{ category.name }}</h1>
                <p v-if="category.description" class="mt-2 text-gray-600 dark:text-gray-300 max-w-2xl">{{ category.description }}</p>
                <p class="mt-3 text-sm text-gray-500 dark:text-gray-400">{{ products.total || products.data?.length || 0 }} products</p>
            </div>
        </div>

        <div class="flex lg:hidden items-center gap-2 mb-4">
            <button type="button" @click="filterOpen = true" class="flex items-center gap-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:border-gray-400 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                Filters
            </button>
        </div>

        <div v-show="filterOpen" class="fixed inset-0 z-50 lg:hidden" @keydown.escape.window="filterOpen = false">
            <div class="absolute inset-0 bg-black/50" @click="filterOpen = false"></div>
            <div class="absolute inset-y-0 left-0 w-80 max-w-[85vw] bg-white dark:bg-gray-900 shadow-xl overflow-y-auto">
                <div class="sticky top-0 bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700 px-4 py-3 flex items-center justify-between z-10">
                    <h2 class="font-bold text-gray-800 dark:text-gray-100">Filters</h2>
                    <button type="button" @click="filterOpen = false" class="p-1 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <div class="p-4">
                    <FilterSidebar :filters="filters" />
                </div>
            </div>
        </div>

        <div class="flex gap-8">
            <div class="w-56 shrink-0 hidden lg:block">
                <FilterSidebar :filters="filters" />
            </div>

            <div class="flex-1 min-w-0">
                <div class="hidden lg:flex items-center justify-between mb-4">
                    <p class="text-sm text-gray-400 dark:text-gray-500">{{ products.total || products.data?.length || 0 }} products</p>
                    <select @change="changeSort" class="bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-sm text-gray-700 dark:text-gray-300 focus:outline-none focus:border-blue-600">
                        <option value="latest" :selected="!urlParams.get('sort') || urlParams.get('sort') === 'latest'">Sort: Latest</option>
                        <option value="price_asc" :selected="urlParams.get('sort') === 'price_asc'">Price: Low to High</option>
                        <option value="price_desc" :selected="urlParams.get('sort') === 'price_desc'">Price: High to Low</option>
                        <option value="name_asc" :selected="urlParams.get('sort') === 'name_asc'">Name: A-Z</option>
                        <option value="name_desc" :selected="urlParams.get('sort') === 'name_desc'">Name: Z-A</option>
                    </select>
                </div>

                <div v-if="products.data && products.data.length" class="grid grid-cols-1 gap-4 md:gap-5">
                    <ProductCard v-for="product in products.data" :key="product.id" :product="product" hide-badges />
                </div>
                <div v-else class="text-center py-20">
                    <svg class="w-16 h-16 mx-auto text-gray-200 dark:text-gray-700 mb-4" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
                        <path d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                    </svg>
                    <p class="text-gray-400 dark:text-gray-500 text-sm">No products found in this category.</p>
                </div>

                <div v-if="products.links && products.links.length > 3" class="mt-8 flex justify-center gap-1">
                    <Link v-for="(link, i) in products.links" :key="i" :href="link.url || '#'" v-html="link.label" class="px-3 py-1.5 text-sm rounded-lg transition"
                        :class="link.active ? 'bg-blue-600 text-white' : 'bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700'"
                        :preserve-scroll="true"
                    />
                </div>
            </div>
        </div>
    </FrontEndMaster>
</template>
