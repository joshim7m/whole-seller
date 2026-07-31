<script setup>
import { ref, computed, watch } from 'vue'
import { Head, Link, usePage } from '@inertiajs/vue3'
import FrontEndMaster from '@/Layouts/Frontend/FrontEndMaster.vue'
import { useCart } from '@/composables/useCart'

const page = usePage()
const isGuest = computed(() => !page.props.auth?.user)

const props = defineProps({
    product: { type: Object, default: () => ({}) },
    related: { type: Array, default: () => [] }
})

const activeImage = ref(0)
const selectedSize = ref('')
const selectedColor = ref('')
const quantity = ref(1)

const images = computed(() => {
    return (props.product.images || []).map(img => img.image_url || img.image_path || img.url)
})

const variants = computed(() => props.product.variants || [])

const uniqueSizes = computed(() => {
    return [...new Set(variants.value.map(v => v.size).filter(Boolean))]
})

const uniqueColors = computed(() => {
    return [...new Set(variants.value.map(v => v.color).filter(Boolean))]
})

const selectedVariant = computed(() => {
    return variants.value.find(v =>
        (v.size === selectedSize.value || (!v.size && !selectedSize.value)) &&
        (v.color === selectedColor.value || (!v.color && !selectedColor.value))
    )
})

const availableQty = computed(() => {
    return selectedVariant.value ? selectedVariant.value.quantity : 0
})

const salePrice = computed(() => {
    if (selectedVariant.value?.sale_price) return Number(selectedVariant.value.sale_price)
    return Number(props.product.sale_price || props.product.unit_price || 0)
})

const originalPrice = computed(() => {
    if (selectedVariant.value?.unit_price) return Number(selectedVariant.value.unit_price)
    return Number(props.product.unit_price || props.product.original_price || 0)
})

function prevImage() {
    activeImage.value = activeImage.value > 0 ? activeImage.value - 1 : 0
}

function nextImage() {
    activeImage.value = activeImage.value < images.value.length - 1 ? activeImage.value + 1 : images.value.length - 1
}

function selectSize(size) {
    selectedSize.value = size
    quantity.value = 1
}

function selectColor(color) {
    selectedColor.value = color
    quantity.value = 1
}

watch(selectedVariant, (variant) => {
    if (variant?.image?.image_url || variant?.image?.image_path) {
        const url = variant.image.image_url || variant.image.image_path
        const idx = images.value.indexOf(url)
        if (idx !== -1) activeImage.value = idx
    }
})

function variantImageUrl(variant) {
    return variant?.image?.image_url || variant?.image?.image_path || null
}

const { addItem: cartAddItem } = useCart()

function addToCart() {
    const variant = selectedVariant.value
    const variantId = variant ? variant.id : null

    const options = []
    if (selectedSize.value) options.push('Size: ' + selectedSize.value)
    if (selectedColor.value) options.push('Color: ' + selectedColor.value)
    const variantLabel = options.join(', ')
    const name = variantLabel ? props.product.title + ' (' + variantLabel + ')' : props.product.title

        cartAddItem({
            product_id: props.product.id,
            variant_id: variantId,
            sku: variant?.sku || '',
            size: selectedSize.value,
            color: selectedColor.value,
            variant_name: variantLabel,
            name: name,
            price: salePrice.value,
            qty: quantity.value,
            image: variantImageUrl(variant) || images.value[0] || null
        })
}

const hasOptions = computed(() => uniqueSizes.value.length + uniqueColors.value.length > 0)
</script>

<template>
    <Head :title="product.name || product.title || 'Product'" />

    <FrontEndMaster>
        <nav class="text-sm text-gray-500 dark:text-gray-400 mb-4 flex items-center gap-1.5">
            <Link :href="route('home')" class="hover:text-blue-600 dark:hover:text-blue-400 transition">Home</Link>
            <svg class="w-3 h-3 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            <Link v-if="product.category" :href="route('category.show', product.category.slug || product.category.id)" class="hover:text-blue-600 dark:hover:text-blue-400 transition">{{ product.category.name }}</Link>
            <svg v-if="product.category" class="w-3 h-3 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            <span class="text-gray-800 dark:text-gray-200 font-medium">{{ product.title }}</span>
        </nav>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="space-y-3">
                <div class="relative aspect-square bg-gray-100 dark:bg-gray-800 rounded-xl overflow-hidden flex items-center justify-center text-gray-400 dark:text-gray-500 text-sm group">
                    <img
                        v-for="(img, i) in images" :key="i"
                        :src="img"
                        :class="{ 'opacity-100': activeImage === i, 'opacity-0': activeImage !== i }"
                        class="absolute inset-0 w-full h-full object-cover transition-opacity duration-300"
                    >
                    <span v-if="!images.length">No Image</span>
                    <button v-if="images.length > 1" @click="prevImage" class="absolute left-2 top-1/2 -translate-y-1/2 w-8 h-8 rounded-full bg-white/80 dark:bg-gray-900/80 hover:bg-white dark:hover:bg-gray-900 text-gray-700 dark:text-gray-300 flex items-center justify-center opacity-0 group-hover:opacity-100 transition shadow-sm">&lsaquo;</button>
                    <button v-if="images.length > 1" @click="nextImage" class="absolute right-2 top-1/2 -translate-y-1/2 w-8 h-8 rounded-full bg-white/80 dark:bg-gray-900/80 hover:bg-white dark:hover:bg-gray-900 text-gray-700 dark:text-gray-300 flex items-center justify-center opacity-0 group-hover:opacity-100 transition shadow-sm">&rsaquo;</button>
                    <div v-if="images.length > 1" class="absolute bottom-3 left-1/2 -translate-x-1/2 flex gap-1.5">
                        <button
                            v-for="(img, i) in images" :key="i"
                            @click="activeImage = i"
                            class="w-2 h-2 rounded-full transition"
                            :class="activeImage === i ? 'bg-white dark:bg-white shadow-sm' : 'bg-white/40 dark:bg-white/40'"
                        ></button>
                    </div>
                </div>
                <div v-if="images.length > 1" class="flex gap-2 overflow-x-auto pb-1">
                    <button
                        v-for="(img, i) in images" :key="i"
                        @click="activeImage = i"
                        class="shrink-0 w-16 h-16 rounded-lg overflow-hidden border-2 transition"
                        :class="{ 'border-blue-600 dark:border-blue-400': activeImage === i, 'border-transparent': activeImage !== i }"
                    >
                        <img :src="img" alt="" class="w-full h-full object-cover">
                    </button>
                </div>
            </div>

            <div>
                <h1 class="text-xl md:text-2xl font-bold text-gray-800 dark:text-white">{{ product.title }}</h1>

                <div v-if="!isGuest" class="mt-3 flex items-center gap-3">
                    <span class="text-xl font-bold text-blue-600 dark:text-blue-400">৳{{ salePrice.toLocaleString() }}</span>
                    <span class="text-base text-gray-400 dark:text-gray-500 line-through">৳{{ originalPrice.toLocaleString() }}</span>
                    <span v-if="originalPrice > salePrice" class="text-xs font-semibold text-green-600 dark:text-green-400 bg-green-100 dark:bg-green-900/30 px-2 py-0.5 rounded-full">Save ৳{{ (originalPrice - salePrice).toLocaleString() }}</span>
                </div>
                <div v-else class="mt-3 font-bengali">
                    <Link :href="route('login')" class="inline-block text-sm md:text-base font-medium text-blue-600 dark:text-blue-400 hover:underline leading-tight">
                        প্রাইস দেখতে লগইন করুন
                    </Link>
                </div>

                <div class="mt-4 flex flex-wrap items-center gap-x-6 gap-y-2 text-sm">
                    <div class="flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                        <span class="text-gray-500 dark:text-gray-400">SKU:</span>
                        <span class="font-mono font-medium text-gray-800 dark:text-gray-200">{{ selectedVariant?.sku || product.sku || '—' }}</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <span v-if="!hasOptions || selectedVariant" class="inline-flex items-center gap-1" :class="(selectedVariant ? availableQty : product.quantity) > 0 ? 'text-green-600 dark:text-green-400' : 'text-red-500 dark:text-red-400'">
                            <span class="w-2 h-2 rounded-full" :class="(selectedVariant ? availableQty : product.quantity) > 0 ? 'bg-green-500 dark:bg-green-400' : 'bg-red-500 dark:bg-red-400'"></span>
                            {{ (selectedVariant ? availableQty : product.quantity) > 0 ? 'In Stock' : 'Out of Stock' }}
                        </span>
                        <span v-else class="text-gray-400 dark:text-gray-500 italic">Select options to check stock</span>
                        <span class="text-gray-400 dark:text-gray-500" v-if="(selectedVariant ? availableQty : product.quantity) > 0">({{ selectedVariant ? availableQty : product.quantity }} available)</span>
                    </div>
                </div>

                <p class="mt-4 text-sm text-gray-600 dark:text-gray-400 leading-relaxed">{{ product.description }}</p>

                <div v-if="uniqueSizes.length" class="mt-4">
                    <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Size</p>
                    <div class="flex flex-wrap gap-2">
                        <button
                            v-for="size in uniqueSizes" :key="size"
                            @click="selectSize(size)"
                            class="px-4 py-1.5 rounded-lg text-sm border transition"
                            :class="selectedSize === size ? 'bg-blue-600 text-white border-blue-600' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border-gray-300 dark:border-gray-600 hover:border-blue-400 dark:hover:border-blue-400'"
                        >{{ size }}</button>
                    </div>
                </div>

                <div v-if="uniqueColors.length" class="mt-3">
                    <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Color</p>
                    <div class="flex flex-wrap gap-2">
                        <button
                            v-for="color in uniqueColors" :key="color"
                            @click="selectColor(color)"
                            class="px-4 py-1.5 rounded-lg text-sm border transition"
                            :class="selectedColor === color ? 'bg-blue-600 text-white border-blue-600' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border-gray-300 dark:border-gray-600 hover:border-blue-400 dark:hover:border-blue-400'"
                        >{{ color }}</button>
                    </div>
                </div>

                <div v-if="!isGuest" class="mt-6 flex items-center gap-3">
                    <div class="flex items-center border border-gray-300 dark:border-gray-600 rounded-lg">
                        <button @click="quantity = Math.max(1, quantity - 1)" class="px-3 py-2.5 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition text-sm leading-none">&minus;</button>
                        <input type="number" v-model.number="quantity" :min="1" :max="availableQty || 1" class="w-12 text-center text-sm border-x border-gray-300 dark:border-gray-600 py-2.5 outline-none bg-transparent text-gray-900 dark:text-white">
                        <button @click="quantity = Math.min(availableQty || 1, quantity + 1)" class="px-3 py-2.5 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition text-sm leading-none">+</button>
                    </div>
                    <button
                        @click="addToCart"
                        :disabled="hasOptions && !selectedVariant"
                        class="bg-blue-600 text-white font-semibold px-6 py-2.5 rounded-lg text-sm transition flex-1"
                        :class="hasOptions && !selectedVariant ? 'opacity-40 cursor-not-allowed' : 'hover:opacity-90'"
                    >{{ hasOptions && !selectedVariant ? 'Select Options' : 'Add to Cart' }}</button>
                </div>
                <div v-else class="mt-6 font-bengali">
                    <Link :href="route('login')" class="block w-full text-center bg-blue-600 text-white font-semibold px-6 py-2.5 rounded-lg text-sm transition hover:opacity-90">
                        অর্ডার করতে লগইন করুন
                    </Link>
                </div>
            </div>
        </div>

        <section v-if="related && related.length" class="mt-12">
            <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-4">Related Products</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <Link
                    v-for="rel in related" :key="rel.id"
                    :href="route('product.show', rel.slug || rel.id)"
                    class="group bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 overflow-hidden shadow-sm hover:shadow-md dark:hover:shadow-gray-900/50 transition"
                >
                    <div class="aspect-square bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-gray-400 dark:text-gray-500 text-xs">
                        <img
                            v-if="rel.images && rel.images.length"
                            :src="rel.images[0]?.image_url || rel.images[0]?.image_path || rel.images[0]?.url"
                            :alt="rel.title"
                            class="w-full h-full object-cover"
                        >
                        <span v-else>No Image</span>
                    </div>
                    <div class="p-3">
                        <h3 class="text-sm font-semibold text-gray-800 dark:text-white truncate group-hover:text-blue-600 dark:group-hover:text-blue-400 transition">{{ rel.title }}</h3>
                        <p v-if="!isGuest" class="mt-1 text-blue-600 dark:text-blue-400 font-bold text-sm">৳{{ Number(rel.sale_price || rel.price || 0).toLocaleString() }}</p>
                        <p v-else class="mt-1 text-xs font-bengali text-blue-600 dark:text-blue-400">প্রাইস দেখতে লগইন করুন</p>
                    </div>
                </Link>
            </div>
        </section>
    </FrontEndMaster>
</template>
