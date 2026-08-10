<script setup>
import { Link } from '@inertiajs/vue3';
import HomeProductCard from '@/Components/StoreFront/HomeProductCard.vue';

defineProps({
    products: {
        type: Array,
        default: () => [],
    },
});
</script>

<template>
    <section v-if="products.length" class="mb-16">
        <div class="mb-6 flex items-end justify-between gap-4">
            <div>
                <h2
                    class="text-xl font-bold text-gray-800 dark:text-white md:text-2xl"
                >
                    Top Selling Products
                </h2>
                <div
                    class="mt-2 h-1.5 w-16 rounded-full bg-gradient-to-r from-[#D9531E] via-amber-400 to-emerald-400"
                ></div>
            </div>
            <Link
                :href="route('products.index')"
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
            class="grid grid-cols-2 gap-3 sm:grid-cols-3 md:gap-5 lg:grid-cols-4"
        >
            <HomeProductCard
                v-for="(product, i) in products"
                :key="product.id"
                :product="product"
                :index="i"
            />
        </div>
    </section>
</template>
