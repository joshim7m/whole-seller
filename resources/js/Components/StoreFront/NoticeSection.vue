<script setup>
defineProps({
    notices: { type: Array, default: () => [] },
})
</script>

<template>
    <section v-if="notices.length > 0" class="mb-16">
        <div class="flex flex-col items-center text-center mb-6">
            <div class="inline-flex items-center justify-center w-12 h-12 bg-amber-500 rounded-2xl mb-3 shadow-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>
                </svg>
            </div>
            <h2 class="text-xl md:text-2xl font-bold text-gray-800 dark:text-white font-bengali">নোটিশ</h2>
            <p class="text-sm text-gray-400 dark:text-gray-500 mt-1 font-bengali">গুরুত্বপূর্ণ ঘোষণা ও তথ্য</p>
        </div>

        <div class="max-w-2xl mx-auto space-y-3 px-0">
            <div
                v-for="notice in notices" :key="notice.id"
                class="flex gap-4 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-4 md:p-5 shadow-sm"
            >
                <div v-if="notice.image" class="shrink-0">
                    <img :src="`/${notice.image}`" :alt="notice.title" class="w-20 h-20 md:w-24 md:h-24 rounded-lg object-cover border border-gray-200 dark:border-gray-700" />
                </div>
                <div class="min-w-0">
                    <h3 class="text-sm md:text-base font-semibold text-gray-800 dark:text-gray-100 font-bengali leading-relaxed">{{ notice.title }}</h3>
                    <p class="mt-1.5 text-xs md:text-sm text-gray-600 dark:text-gray-400 font-bengali leading-relaxed">{{ notice.content }}</p>
                </div>
            </div>
        </div>
    </section>
</template>
