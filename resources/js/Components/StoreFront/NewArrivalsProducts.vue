<script setup>
import { Link } from '@inertiajs/vue3'
import ProductCard from '@/Components/StoreFront/ProductCard.vue'

defineProps({
    products: {
        type: Array,
        default: () => []
    }
})
</script>

<template>
    <section v-if="products.length" class="mb-16">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl md:text-2xl font-bold text-gray-800 dark:text-white">New Arrivals</h2>
            <Link :href="route('products.new-arrivals')" class="text-sm text-blue-600 dark:text-blue-400 hover:underline font-medium">View All</Link>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-6 gap-3 md:gap-3">
            <ProductCard v-for="product in products" :key="product.id" :product="product" compact />
        </div>
    </section>
</template>
