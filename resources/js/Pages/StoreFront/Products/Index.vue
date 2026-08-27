<script setup>
import { ref, computed } from 'vue'
import { Head, Link, router } from '@inertiajs/vue3'
import FrontEndMaster from '@/Layouts/Frontend/FrontEndMaster.vue'
import FilterSidebar from '@/Components/StoreFront/FilterSidebar.vue'
import ProductCard from '@/Components/StoreFront/ProductCard.vue'

const props = defineProps({
    products: { type: Object, default: () => ({ data: [], total: 0 }) },
    filters: { type: Object, default: () => ({}) }
})

const filterOpen = ref(false)
const urlParams = new URL(window.location.href).searchParams

function changeSort(event) {
    const params = new URLSearchParams(window.location.search)
    params.set('sort', event.target.value)
    router.get(window.location.pathname + '?' + params.toString(), {}, { preserveScroll: true, preserveState: true })
}

const paginationLinks = computed(() => {
    if (!props.products.links) return []
    return props.products.links.map(link => {
        if (link.label === '&laquo; Previous') {
            return { ...link, label: '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>' }
        }
        if (link.label === 'Next &raquo;') {
            return { ...link, label: '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>' }
        }
        return link
    })
})
</script>

<template>
    <Head title="Products" />

    <FrontEndMaster>
        <nav class="text-sm text-gray-500 mb-4 flex items-center gap-1.5">
            <Link :href="route('home')" class="hover:text-blue-600 transition-colors">Home</Link>
            <svg class="w-3 h-3 text-gray-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            <span class="text-gray-800 font-medium">All Products</span>
        </nav>

        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl md:text-3xl lg:text-4xl font-bold text-gray-800">All Products</h1>
                <p class="text-sm text-gray-500 mt-1">Discover the latest trends and styles.</p>
            </div>
            <p class="text-sm text-gray-400 shrink-0 ml-4">{{ products.total || 0 }} products</p>
        </div>

        <div class="flex lg:hidden items-center gap-2 mb-4">
            <button type="button" @click="filterOpen = true" class="flex items-center gap-2 bg-white border border-gray-300 rounded-lg px-4 py-2 text-sm text-gray-700 hover:border-gray-400 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                Filters
            </button>
            <div v-if="urlParams.get('q')" class="text-sm text-gray-500">
                Searching: "<span class="font-medium text-gray-700">{{ urlParams.get('q') }}</span>"
                <Link :href="window.location.pathname" class="text-blue-600 hover:underline ml-1">Clear</Link>
            </div>
        </div>

        <div v-if="urlParams.get('q')" class="hidden lg:flex items-center gap-2 mb-4">
            <div class="text-sm text-gray-500">
                Results for: "<span class="font-medium text-gray-700">{{ urlParams.get('q') }}</span>"
            </div>
        </div>

        <div v-show="filterOpen" class="fixed inset-0 z-50 lg:hidden" @keydown.escape.window="filterOpen = false">
            <div class="absolute inset-0 bg-black/50" @click="filterOpen = false"></div>
            <div class="absolute inset-y-0 left-0 w-80 max-w-[85vw] bg-white shadow-xl overflow-y-auto">
                <div class="sticky top-0 bg-white border-b border-gray-200 px-4 py-3 flex items-center justify-between z-10">
                    <h2 class="font-bold text-gray-800">Filters</h2>
                    <button type="button" @click="filterOpen = false" class="p-1 rounded-lg hover:bg-gray-100 transition">
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
                    <p class="text-sm text-gray-400">{{ products.total || 0 }} products</p>
                    <select @change="changeSort" class="bg-white border border-gray-300 rounded-lg px-3 py-2 text-sm text-gray-700 focus:outline-none focus:border-blue-600">
                        <option value="latest" :selected="urlParams.get('sort') === 'latest' || !urlParams.get('sort')">Sort: Latest</option>
                        <option value="price_asc" :selected="urlParams.get('sort') === 'price_asc'">Price: Low to High</option>
                        <option value="price_desc" :selected="urlParams.get('sort') === 'price_desc'">Price: High to Low</option>
                        <option value="name_asc" :selected="urlParams.get('sort') === 'name_asc'">Name: A-Z</option>
                        <option value="name_desc" :selected="urlParams.get('sort') === 'name_desc'">Name: Z-A</option>
                    </select>
                </div>

                <div v-if="products.data && products.data.length" class="grid grid-cols-2 gap-3 sm:gap-4 lg:grid-cols-5">
                    <ProductCard v-for="product in products.data" :key="product.id" :product="product" />
                </div>
                <div v-else class="text-center py-20">
                    <svg class="w-16 h-16 mx-auto text-gray-200 mb-4" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
                        <path d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                    </svg>
                    <p class="text-gray-400 text-sm">No products found.</p>
                    <Link :href="window.location.pathname" class="mt-2 inline-block text-sm text-blue-600 hover:underline">Clear filters</Link>
                </div>

                <div v-if="products.links && products.links.length > 3" class="mt-10 flex items-center justify-center gap-1 flex-wrap">
                    <Link
                        v-for="(link, i) in paginationLinks"
                        :key="i"
                        :href="link.url || '#'"
                        class="relative inline-flex items-center justify-center min-w-[40px] h-10 text-sm font-medium rounded-xl transition-all duration-200"
                        :class="[
                            link.active
                                ? 'bg-[#D9531E] text-white shadow-lg shadow-orange-200/70 dark:shadow-orange-900/30 scale-105'
                                : link.url
                                    ? 'bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-400 border border-gray-200 dark:border-gray-700 hover:border-[#D9531E] hover:text-[#D9531E] dark:hover:border-orange-500 dark:hover:text-orange-400 hover:shadow-md'
                                    : 'bg-gray-50 dark:bg-gray-900 text-gray-300 dark:text-gray-600 cursor-not-allowed border border-gray-100 dark:border-gray-800'
                        ]"
                        v-html="link.label"
                        :preserve-scroll="true"
                    />
                </div>
            </div>
        </div>
    </FrontEndMaster>
</template>
