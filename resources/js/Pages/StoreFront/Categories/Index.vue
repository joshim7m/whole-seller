<script setup>
import { Head, Link } from '@inertiajs/vue3'
import FrontEndMaster from '@/Layouts/Frontend/FrontEndMaster.vue'

defineProps({
    categories: { type: Array, default: () => [] }
})

const backdrops = [
    'bg-gradient-to-br from-orange-50 via-rose-50 to-indigo-100',
    'bg-gradient-to-br from-indigo-50 via-sky-50 to-emerald-100',
    'bg-gradient-to-br from-rose-50 via-amber-50 to-lime-100',
    'bg-gradient-to-br from-violet-50 via-fuchsia-50 to-orange-100',
    'bg-gradient-to-br from-emerald-50 via-teal-50 to-blue-100',
]

const accents = [
    'bg-gradient-to-r from-[#D9531E] via-amber-400 to-emerald-400',
    'bg-gradient-to-r from-indigo-500 via-sky-400 to-emerald-400',
    'bg-gradient-to-r from-rose-500 via-fuchsia-400 to-indigo-400',
    'bg-gradient-to-r from-violet-500 via-purple-400 to-pink-400',
    'bg-gradient-to-r from-teal-500 via-cyan-400 to-blue-400',
]

const backdropFor = (i) => backdrops[i % backdrops.length]
const accentFor = (i) => accents[i % accents.length]

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
                v-for="(cat, i) in categories" :key="cat.id"
                :href="route('category.show', cat.slug || cat.id)"
                class="group relative rounded-2xl overflow-hidden bg-white dark:bg-gray-800 border border-gray-200/80 dark:border-gray-700 shadow-sm hover:shadow-xl hover:shadow-orange-100/60 dark:hover:shadow-gray-900/50 hover:border-orange-200 dark:hover:border-gray-600 transition-all duration-300"
            >
                <div :class="accentFor(i)" class="absolute inset-x-0 top-0 h-[3px] opacity-80"></div>
                <div :class="backdropFor(i)" class="aspect-[4/3] flex items-center justify-center text-gray-200 dark:text-gray-600 overflow-hidden">
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
                    <h3 class="font-bold text-[#0B132A] dark:text-gray-100 text-sm md:text-base truncate group-hover:text-[#D9531E] dark:group-hover:text-orange-400 transition-colors">{{ cat.name }}</h3>
                    <p v-if="cat.products_count !== undefined" class="mt-1.5">
                        <span class="inline-flex items-center gap-1 text-[11px] font-semibold px-2 py-0.5 rounded-full bg-orange-50 dark:bg-orange-500/10 text-orange-600 dark:text-orange-400 border border-orange-200 dark:border-orange-500/30">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                            {{ cat.products_count }} {{ cat.products_count === 1 ? 'product' : 'products' }}
                        </span>
                    </p>
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
