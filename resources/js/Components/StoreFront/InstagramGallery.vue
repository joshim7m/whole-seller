<script setup>
import { usePage } from '@inertiajs/vue3'

defineProps({
    instagramImages: {
        type: Array,
        default: () => []
    }
})

const page = usePage()
const settings = page.props.settings || {}
</script>

<template>
    <section class="mb-16">
        <div class="flex flex-col items-center text-center mb-6">
            <div class="inline-flex items-center justify-center w-12 h-12 bg-gradient-to-tr from-pink-500 via-purple-500 to-blue-500 rounded-2xl mb-3 shadow-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <h2 class="text-xl md:text-2xl font-bold text-gray-800 dark:text-white">Follow Us on Instagram</h2>
            <a
                v-if="settings.instagram_handler"
                :href="'https://instagram.com/' + settings.instagram_handler"
                target="_blank"
                class="text-lg font-bold text-transparent bg-clip-text bg-gradient-to-r from-pink-500 via-purple-500 to-blue-500 hover:opacity-80 transition"
            >@{{ settings.instagram_handler }}</a>
            <p v-else class="text-sm text-gray-400 dark:text-gray-500 mt-1">{{ settings.company_name || 'Our Store' }}</p>
        </div>

        <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-2 md:gap-3">
            <template v-if="instagramImages.length">
                <a
                    v-for="img in instagramImages.slice(0, 6)" :key="img.id"
                    :href="settings.instagram_handler ? 'https://instagram.com/' + settings.instagram_handler : '#'"
                    :target="settings.instagram_handler ? '_blank' : '_self'"
                    class="group relative aspect-square rounded-xl overflow-hidden bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md dark:hover:shadow-gray-900/50 transition-all"
                >
                    <img :src="'/' + img.image" :alt="img.title" class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors" />
                </a>
            </template>
            <template v-else>
                <div
                    v-for="i in 6" :key="i"
                    class="aspect-square rounded-xl bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-700 border border-gray-200 dark:border-gray-700 flex items-center justify-center"
                >
                    <svg class="w-8 h-8 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            </template>
        </div>

        <div v-if="settings.instagram_handler" class="text-center mt-5">
            <a
                :href="'https://instagram.com/' + settings.instagram_handler"
                target="_blank"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-pink-500 via-purple-500 to-blue-500 text-white text-sm font-semibold rounded-full hover:opacity-90 transition shadow-md"
            >
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                Follow on Instagram
            </a>
        </div>
    </section>
</template>
