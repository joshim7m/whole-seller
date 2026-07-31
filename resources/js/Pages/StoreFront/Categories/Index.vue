<script setup>
import { Head, Link } from '@inertiajs/vue3'
import FrontEndMaster from '@/Layouts/Frontend/FrontEndMaster.vue'

defineProps({
    categories: { type: Array, default: () => [] }
})
</script>

<template>
    <Head title="Categories" />

    <FrontEndMaster>
        <nav class="text-sm text-gray-500 dark:text-gray-400 mb-4 flex items-center gap-1.5">
            <Link :href="route('home')" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Home</Link>
            <svg class="w-3 h-3 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            <span class="text-gray-800 dark:text-gray-200 font-medium">Categories</span>
        </nav>

        <div class="mb-6">
            <h1 class="text-2xl md:text-3xl lg:text-4xl font-bold text-gray-800 dark:text-white">Categories</h1>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Browse our product categories</p>
        </div>

        <div v-if="categories.length" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-3 md:gap-4">
            <Link
                v-for="cat in categories" :key="cat.id"
                :href="route('category.show', cat.slug || cat.id)"
                class="group relative rounded-xl overflow-hidden bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-lg dark:hover:shadow-gray-900/50 transition-all duration-300"
            >
                <div class="aspect-[4/3] bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-gray-300 dark:text-gray-600 overflow-hidden">
                    <img
                        v-if="cat.image_url"
                        :src="cat.image_url"
                        :alt="cat.name"
                        class="w-full h-full object-cover group-hover:scale-110 transition duration-300"
                    >
                    <svg v-else class="w-12 h-12" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
                        <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div class="p-3 md:p-4">
                    <h3 class="font-bold text-gray-800 dark:text-gray-100 text-sm md:text-base truncate group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">{{ cat.name }}</h3>
                    <p v-if="cat.products_count !== undefined" class="mt-1 text-xs text-gray-400 dark:text-gray-500">{{ cat.products_count }} {{ cat.products_count === 1 ? 'product' : 'products' }}</p>
                </div>
            </Link>
        </div>
        <div v-else class="text-center py-20">
            <svg class="w-16 h-16 mx-auto text-gray-200 dark:text-gray-700 mb-4" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
                <path d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
            </svg>
            <p class="text-gray-400 dark:text-gray-500 text-sm">No categories found.</p>
        </div>
    </FrontEndMaster>
</template>
