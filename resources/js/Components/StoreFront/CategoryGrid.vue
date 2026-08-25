<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    categories: { type: Array, default: () => [] },
});
</script>

<template>
    <section v-if="categories.length" class="mb-16">
        <div
            class="mb-6 flex gap-2 border-b border-gray-200 pb-4 justify-between sm:gap-4 dark:border-gray-700 md:mb-8 md:pb-6"
        >
           <div>
                <h2
                    class="text-xl font-bold text-gray-800 dark:text-white md:text-2xl"
                >
                    Top Category
                </h2>
                <div
                    class="mt-2 h-1.5 w-16 rounded-full bg-gradient-to-r from-[#D9531E] via-amber-400 to-emerald-400"
                ></div>
            </div>
            <div class="flex items-center gap-3">
                <Link
                    :href="route('categories.index')"
                    class="group/link inline-flex items-center gap-1.5 text-sm font-semibold text-[#D9531E] transition-all duration-300 hover:gap-2.5 dark:text-orange-400"
                >
                    View All
                    <svg
                        class="h-4 w-4 transition-transform duration-300 group-hover/link:translate-x-0.5"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M13 7l5 5m0 0l-5 5m5-5H6"
                        />
                    </svg>
                </Link>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-3 sm:gap-4 lg:grid-cols-5 lg:gap-5">
            <Link
                v-for="category in categories"
                :key="category.id"
                :href="category.id === 'others' ? route('categories.index') : route('category.show', category.slug || category.id)"
                class="group relative flex flex-col rounded-xl border border-gray-200 bg-white p-4 transition-all duration-300 hover:border-[#D9531E]/30 hover:shadow-lg dark:border-gray-700 dark:bg-gray-800 dark:hover:border-orange-500/30 sm:p-5 lg:p-6"
            >
                <span
                    v-if="category.products_count !== undefined"
                    class="absolute right-3 top-3 z-10 rounded-full bg-[#D9531E] px-2 py-0.5 text-[10px] font-bold tracking-wider text-white sm:text-xs lg:px-2.5 lg:py-1"
                >
                    {{ category.products_count }}
                    {{ category.products_count === 1 ? 'Item' : 'Items' }}
                </span>

                <div
                    class="mb-4 flex h-16 w-16 items-center justify-center overflow-hidden rounded-xl bg-gray-100 transition-transform duration-300 group-hover:scale-105 sm:h-20 sm:w-20 dark:bg-gray-700"
                >
                    <img
                        v-if="category.image_url"
                        :src="category.image_url"
                        :alt="category.name"
                        class="h-full w-full object-cover"
                        loading="lazy"
                    />
                    <svg
                        v-else
                        class="h-8 w-8 text-gray-400 dark:text-gray-500"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.5"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                        />
                    </svg>
                </div>

                <h3
                    class="mb-2 truncate text-sm font-semibold text-gray-900 dark:text-white sm:text-base"
                >
                    {{ category.name }}
                </h3>

                <div
                    class="mt-auto flex items-center gap-1.5 text-xs font-bold uppercase tracking-wider text-[#D9531E] dark:text-orange-400 sm:text-sm"
                >
                    BROWSE
                    <svg
                        class="h-3.5 w-3.5 transition-transform duration-300 group-hover:translate-x-1 sm:h-4 sm:w-4"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M17 8l4 4m0 0l-4 4m4-4H3"
                        />
                    </svg>
                </div>
            </Link>
        </div>
    </section>
</template>
