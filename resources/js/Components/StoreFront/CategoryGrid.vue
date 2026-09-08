<script setup>
import { Link } from '@inertiajs/vue3';
import { Swiper, SwiperSlide } from 'swiper/vue';
import { Grid, Pagination } from 'swiper/modules';
import { ref } from 'vue';
import 'swiper/css';
import 'swiper/css/grid';
import 'swiper/css/pagination';

defineProps({
    categories: { type: Array, default: () => [] },
});

const swiper = ref(null);
const isBeginning = ref(true);
const isEnd = ref(true);

function syncState() {
    const s = swiper.value;
    if (!s) return;
    isBeginning.value = s.isBeginning;
    isEnd.value = s.isEnd;
}

function onSwiper(instance) {
    swiper.value = instance;
    syncState();
}

function prev() {
    swiper.value?.slidePrev();
}

function next() {
    swiper.value?.slideNext();
}
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
                <div class="hidden items-center gap-2 md:flex">
                    <button
                        @click="prev"
                        :disabled="isBeginning"
                        class="flex h-9 w-9 items-center justify-center rounded-full border border-gray-200 bg-white text-gray-600 shadow-sm transition-all duration-300 hover:border-orange-200 hover:text-[#D9531E] hover:shadow-md disabled:cursor-not-allowed disabled:opacity-40 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:border-orange-500/40 dark:hover:text-orange-400 md:h-10 md:w-10"
                        aria-label="Previous categories"
                    >
                        <svg class="h-4 w-4 md:h-5 md:w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <button
                        @click="next"
                        :disabled="isEnd"
                        class="flex h-9 w-9 items-center justify-center rounded-full border border-gray-200 bg-white text-gray-600 shadow-sm transition-all duration-300 hover:border-orange-200 hover:text-[#D9531E] hover:shadow-md disabled:cursor-not-allowed disabled:opacity-40 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:border-orange-500/40 dark:hover:text-orange-400 md:h-10 md:w-10"
                        aria-label="Next categories"
                    >
                        <svg class="h-4 w-4 md:h-5 md:w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
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
        </div>

        <Swiper
            :modules="[Grid, Pagination]"
            :slides-per-view="3"
            :grid="{ rows: 2, fill: 'row' }"
            :space-between="12"
            :pagination="{ clickable: true }"
            :breakpoints="{
                768: {
                    slidesPerView: 4,
                    spaceBetween: 16,
                },
                1024: {
                    slidesPerView: 6,
                    spaceBetween: 20,
                },
            }"
            class="category-swiper"
            @swiper="onSwiper"
            @init="syncState"
            @slide-change="syncState"
            @resize="syncState"
        >
            <SwiperSlide
                v-for="category in categories"
                :key="category.id"
            >
                <Link
                    :href="route('category.show', category.slug || category.id)"
                    class="group flex h-full w-full cursor-pointer flex-col items-center py-3 sm:py-4"
                >
                    <div
                        class="mb-3 h-24 w-24 shrink-0 overflow-hidden rounded-full border-4 border-white bg-white shadow-md transition-all duration-300 ease-out group-hover:border-[#D9531E]/30 group-hover:shadow-xl group-hover:shadow-[#D9531E]/25 dark:border-gray-700 dark:bg-gray-800 dark:group-hover:border-orange-500/30 dark:group-hover:shadow-orange-500/25 sm:h-28 sm:w-28"
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
                            class="h-10 w-10 text-gray-400 dark:text-gray-500"
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
                        class="line-clamp-2 text-center text-sm font-semibold leading-snug text-gray-900 transition-colors group-hover:text-[#D9531E] dark:text-white dark:group-hover:text-orange-400 sm:text-base"
                    >
                        {{ category.name }}
                    </h3>

                    <span
                        class="mt-1 text-xs text-gray-500 dark:text-gray-400"
                    >
                        {{ category.products_count ?? 0 }}
                        {{ (category.products_count ?? 0) === 1 ? 'Item' : 'Items' }}
                    </span>
                </Link>
            </SwiperSlide>
        </Swiper>
    </section>
</template>

<style>
.category-swiper .swiper-slide {
    height: auto;
}

.category-swiper .swiper-pagination {
    position: static;
    margin-top: 1.5rem;
}

.category-swiper .swiper-pagination-bullet {
    width: 8px;
    height: 8px;
    background: #D9531E;
    opacity: 0.3;
    transition: all 0.3s ease;
}

.category-swiper .swiper-pagination-bullet-active {
    opacity: 1;
    width: 24px;
    border-radius: 9999px;
}

.category-swiper .swiper-pagination-bullet:hover {
    opacity: 0.7;
}

.dark .category-swiper .swiper-pagination-bullet {
    background: #fb923c;
}
</style>
