<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    categories: { type: Array, default: () => [] },
});

const backdrops = [
    'bg-gradient-to-br from-orange-100 via-rose-50 to-indigo-100',
    'bg-gradient-to-br from-indigo-100 via-sky-50 to-emerald-100',
    'bg-gradient-to-br from-rose-100 via-amber-50 to-lime-100',
    'bg-gradient-to-br from-violet-100 via-fuchsia-50 to-orange-100',
    'bg-gradient-to-br from-emerald-100 via-teal-50 to-blue-100',
];

const accents = [
    'from-[#D9531E] via-amber-400 to-emerald-400',
    'from-indigo-500 via-sky-400 to-emerald-400',
    'from-rose-500 via-fuchsia-400 to-indigo-400',
    'from-violet-500 via-purple-400 to-pink-400',
    'from-teal-500 via-cyan-400 to-blue-400',
];

const backdropFor = (i) => backdrops[i % backdrops.length];
const accentFor = (i) => accents[i % accents.length];
</script>

<template>
    <section v-if="categories.length" class="mb-16">
        <div class="mb-6 flex items-end justify-between gap-4">
            <div>
                <h2
                    class="text-xl font-bold text-gray-800 dark:text-white md:text-2xl"
                >
                    Shop by Category
                </h2>
                <div
                    class="mt-2 h-1.5 w-16 rounded-full bg-gradient-to-r from-[#D9531E] via-amber-400 to-emerald-400"
                ></div>
            </div>
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

        <div
            class="grid grid-cols-3 gap-3 sm:grid-cols-3 md:gap-5 lg:grid-cols-4 xl:grid-cols-5"
        >
            <Link
                v-for="(cat, i) in categories"
                :key="cat.id"
                :href="route('category.show', cat.slug || cat.id)"
                class="group relative flex flex-col rounded-[2rem] border border-gray-200/80 bg-white p-2.5 shadow-sm transition-all duration-300 hover:-translate-y-1.5 hover:border-orange-200 hover:shadow-2xl hover:shadow-orange-100/70 dark:border-gray-700 dark:bg-gray-800 dark:hover:border-gray-600 dark:hover:shadow-gray-900/60"
            >
                <span
                    :class="accentFor(i)"
                    class="absolute inset-x-10 top-0 h-1 rounded-b-full bg-gradient-to-r opacity-80"
                ></span>

                <div
                    :class="backdropFor(i)"
                    class="relative flex aspect-[4/3] items-center justify-center overflow-hidden rounded-[1.5rem] text-gray-300 dark:text-gray-600"
                >
                    <img
                        v-if="cat.image_url"
                        :src="cat.image_url"
                        :alt="cat.name"
                        class="h-full w-full object-cover transition-transform duration-500 ease-out group-hover:scale-110"
                        loading="lazy"
                    />
                    <svg
                        v-else
                        class="h-12 w-12"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1"
                        viewBox="0 0 24 24"
                    >
                        <path
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                        />
                    </svg>

                    <div
                        class="absolute inset-0 bg-gradient-to-t from-black/5 to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100"
                    ></div>
                </div>

                <div class="hidden md:flex items-center justify-center gap-2 p-2.5 pt-3">
                    <div class="min-w-0">
                        <h3
                            class="truncate text-sm font-bold text-[#0B132A] transition-colors group-hover:text-[#D9531E] dark:text-gray-100 dark:group-hover:text-orange-400 md:text-base"
                        >
                            {{ cat.name }}
                        </h3>
                        <p
                            v-if="cat.products_count !== undefined"
                            class="mt-1.5"
                        >
                            <span
                                class="hidden md:inline-flex items-center gap-1 rounded-full border border-orange-200 bg-orange-50 px-2 py-0.5 text-[11px] font-semibold text-orange-600 dark:border-orange-500/30 dark:bg-orange-500/10 dark:text-orange-400"
                            >
                                <svg
                                    class="h-3 w-3"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"
                                    />
                                </svg>
                                {{ cat.products_count }}
                                {{
                                    cat.products_count === 1
                                        ? 'product'
                                        : 'products'
                                }}
                            </span>
                        </p>
                    </div>

                    <span
                        class="hidden md:flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-[#D9531E] to-orange-500 text-white shadow-md shadow-orange-200/70 transition-all duration-300 group-hover:rotate-45 group-hover:scale-105 group-hover:from-orange-500 group-hover:to-orange-400 dark:shadow-orange-900/30"
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
                                d="M7 17L17 7m0 0H8m9 0v9"
                            />
                        </svg>
                    </span>
                </div>
            </Link>
        </div>
    </section>
</template>
