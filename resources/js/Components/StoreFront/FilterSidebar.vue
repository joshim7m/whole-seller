<script setup>
import { ref, computed } from 'vue'
import { router } from '@inertiajs/vue3'

const props = defineProps({
    filters: {
        type: Object,
        default: () => ({})
    }
})

const categories = computed(() => props.filters.categories || [])
const sizes = computed(() => props.filters.sizes || [])
const colors = computed(() => props.filters.colors || [])
const prices = computed(() => props.filters.prices || null)

const urlParams = computed(() => new URL(window.location.href).searchParams)

const selectedCats = computed(() => urlParams.value.getAll('categories'))
const selectedSizes = computed(() => urlParams.value.getAll('sizes'))
const selectedColors = computed(() => urlParams.value.getAll('colors'))
const minPriceParam = computed(() => urlParams.value.get('min_price'))
const maxPriceParam = computed(() => urlParams.value.get('max_price'))
const qParam = computed(() => urlParams.value.get('q'))

const categoryOpen = ref(true)
const sizeOpen = ref(true)
const colorOpen = ref(true)
const priceOpen = ref(true)

const minPrice = ref(Number(minPriceParam.value) || (prices.value?.min_price || 0))
const maxPrice = ref(Number(maxPriceParam.value) || (prices.value?.max_price || 100000))

const activeFilterCount = computed(() => {
    let count = 0
    count += selectedCats.value.length
    count += selectedSizes.value.length
    count += selectedColors.value.length
    if (minPriceParam.value) count++
    if (maxPriceParam.value) count++
    return count
})

function submitForm() {
    const params = new URLSearchParams()
    if (qParam.value) params.set('q', qParam.value)

    for (const cat of selectedCats.value) {
        params.append('categories', cat)
    }
    for (const size of selectedSizes.value) {
        params.append('sizes', size)
    }
    for (const color of selectedColors.value) {
        params.append('colors', color)
    }
    if (Number(minPrice.value) > (prices.value?.min_price || 0)) {
        params.set('min_price', minPrice.value)
    }
    if (Number(maxPrice.value) < (prices.value?.max_price || 100000)) {
        params.set('max_price', maxPrice.value)
    }

    const qs = params.toString()
    const url = window.location.pathname + (qs ? '?' + qs : '')
    router.get(url, {}, { preserveScroll: true, preserveState: true })
}

function clearFilters() {
    router.get(window.location.pathname, {}, { preserveScroll: true, preserveState: true })
}

function toggleCategory(id) {
    const idx = selectedCats.value.indexOf(String(id))
    if (idx > -1) {
        selectedCats.value.splice(idx, 1)
    } else {
        selectedCats.value.push(String(id))
    }
    submitForm()
}

function toggleSize(size) {
    const idx = selectedSizes.value.indexOf(size)
    if (idx > -1) {
        selectedSizes.value.splice(idx, 1)
    } else {
        selectedSizes.value.push(size)
    }
    submitForm()
}

function toggleColor(color) {
    const idx = selectedColors.value.indexOf(color)
    if (idx > -1) {
        selectedColors.value.splice(idx, 1)
    } else {
        selectedColors.value.push(color)
    }
    submitForm()
}

function applyPrice() {
    submitForm()
}

const colorHex = (color) => {
    const map = {
        red: '#ef4444',
        black: '#1a1a1a',
        white: '#ffffff',
        blue: '#3b82f6',
        green: '#22c55e',
        pink: '#ec4899',
        purple: '#a855f7',
        grey: '#6b7280',
        gray: '#6b7280',
        navy: '#1e3a5f',
        brown: '#8b4513',
        beige: '#f5f5dc',
        champagne: '#f7e7ce',
        'dusty pink': '#d8a7b0',
        'army green': '#4b5320',
        olive: '#808000',
        'hot pink': '#ff69b4',
        bronze: '#cd7f32',
        'multi colour': '#d1d5db',
        multicolor: '#d1d5db',
        multicolour: '#d1d5db',
        multi: '#d1d5db',
        'baby pink': '#f4c2c2',
        'mint blue': '#a2d8d8',
    }
    return map[color.toLowerCase()] || '#d1d5db'
}
</script>

<template>
    <aside class="space-y-5">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                </svg>
                <h2 class="font-bold text-gray-800 dark:text-gray-100 text-sm">Filters</h2>
                <span v-if="activeFilterCount" class="text-[10px] font-semibold bg-blue-600 text-white px-1.5 py-0.5 rounded-full">{{ activeFilterCount }}</span>
            </div>
            <button v-if="activeFilterCount" @click="clearFilters" class="text-xs text-blue-600 dark:text-blue-400 hover:underline font-medium">Clear all</button>
        </div>

        <hr class="border-gray-200 dark:border-gray-700">

        <div v-if="categories.length" class="space-y-1">
            <button @click="categoryOpen = !categoryOpen" class="flex items-center justify-between w-full text-left group">
                <span class="text-sm font-semibold text-gray-700 dark:text-gray-300 group-hover:text-gray-900 dark:group-hover:text-white transition-colors">Category</span>
                <svg class="w-3.5 h-3.5 text-gray-400 dark:text-gray-500 transition-transform duration-200" :class="{ 'rotate-180': categoryOpen }" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
            </button>
            <div v-show="categoryOpen" class="mt-2 space-y-1 max-h-56 overflow-y-auto category-scroll">
                <label v-for="cat in categories" :key="cat.id" class="flex items-center gap-2.5 cursor-pointer group rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800/50 px-1.5 py-1 -mx-1.5 transition-colors">
                    <input
                        type="checkbox"
                        :checked="selectedCats.includes(String(cat.id))"
                        @change="toggleCategory(cat.id)"
                        class="rounded border-gray-300 dark:border-gray-600 text-blue-600 focus:ring-blue-500 focus:ring-offset-0 w-4 h-4 dark:bg-gray-700 dark:checked:bg-blue-600 dark:checked:border-blue-600"
                    >
                    <span class="text-sm text-gray-600 dark:text-gray-400 group-hover:text-gray-800 dark:group-hover:text-gray-200 transition-colors flex-1">{{ cat.name }}</span>
                    <span class="text-[11px] text-gray-400 dark:text-gray-600 font-medium">{{ cat.products_count || 0 }}</span>
                </label>
            </div>
            <hr class="border-gray-200 dark:border-gray-700 mt-3">
        </div>

        <div v-if="sizes.length" class="space-y-1">
            <button @click="sizeOpen = !sizeOpen" class="flex items-center justify-between w-full text-left group">
                <span class="text-sm font-semibold text-gray-700 dark:text-gray-300 group-hover:text-gray-900 dark:group-hover:text-white transition-colors">Size</span>
                <svg class="w-3.5 h-3.5 text-gray-400 dark:text-gray-500 transition-transform duration-200" :class="{ 'rotate-180': sizeOpen }" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
            </button>
            <div v-show="sizeOpen" class="mt-2 flex flex-wrap gap-1.5">
                <label v-for="size in sizes" :key="size" class="cursor-pointer">
                    <input
                        type="checkbox"
                        :checked="selectedSizes.includes(size)"
                        @change="toggleSize(size)"
                        class="sr-only peer"
                    >
                    <span class="inline-block px-3 py-1.5 text-xs font-medium rounded-lg border transition-all peer-checked:bg-gray-900 dark:peer-checked:bg-white peer-checked:text-white dark:peer-checked:text-gray-900 peer-checked:border-gray-900 dark:peer-checked:border-white peer-hover:border-gray-400 dark:peer-hover:border-gray-500 border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-400 bg-white dark:bg-gray-800">
                        {{ size }}
                    </span>
                </label>
            </div>
            <hr class="border-gray-200 dark:border-gray-700 mt-3">
        </div>

        <div v-if="colors.length" class="space-y-1">
            <button @click="colorOpen = !colorOpen" class="flex items-center justify-between w-full text-left group">
                <span class="text-sm font-semibold text-gray-700 dark:text-gray-300 group-hover:text-gray-900 dark:group-hover:text-white transition-colors">Color</span>
                <svg class="w-3.5 h-3.5 text-gray-400 dark:text-gray-500 transition-transform duration-200" :class="{ 'rotate-180': colorOpen }" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
            </button>
            <div v-show="colorOpen" class="mt-2 flex flex-wrap gap-2">
                <label v-for="color in colors" :key="color" class="cursor-pointer group flex flex-col items-center gap-0.5" :title="color">
                    <input
                        type="checkbox"
                        :checked="selectedColors.includes(color)"
                        @change="toggleColor(color)"
                        class="sr-only peer"
                    >
                    <span
                        class="inline-block w-7 h-7 rounded-full border-2 transition-all peer-checked:scale-110 peer-checked:shadow-md peer-checked:ring-2 peer-checked:ring-offset-1 peer-checked:ring-blue-600 dark:peer-checked:ring-offset-gray-900"
                        :style="{
                            backgroundColor: colorHex(color),
                            borderColor: color.toLowerCase() === 'white' || color.toLowerCase() === 'beige' || color.toLowerCase() === 'champagne' ? '#d1d5db' : 'transparent'
                        }"
                    ></span>
                    <span class="text-[10px] text-gray-400 dark:text-gray-500 truncate max-w-[3rem] text-center leading-tight peer-checked:text-blue-600 dark:peer-checked:text-blue-400 transition-colors">{{ color }}</span>
                </label>
            </div>
            <hr class="border-gray-200 dark:border-gray-700 mt-3">
        </div>

        <div v-if="prices" class="space-y-1">
            <button @click="priceOpen = !priceOpen" class="flex items-center justify-between w-full text-left group">
                <span class="text-sm font-semibold text-gray-700 dark:text-gray-300 group-hover:text-gray-900 dark:group-hover:text-white transition-colors">Price Range</span>
                <svg class="w-3.5 h-3.5 text-gray-400 dark:text-gray-500 transition-transform duration-200" :class="{ 'rotate-180': priceOpen }" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
            </button>
            <div v-show="priceOpen" class="mt-3 space-y-3">
                <div class="flex items-center gap-2">
                    <div class="flex-1">
                        <label class="text-[10px] text-gray-400 dark:text-gray-500 uppercase tracking-wide font-medium">Min</label>
                        <div class="relative mt-1">
                            <span class="absolute left-2.5 top-1/2 -translate-y-1/2 text-xs text-gray-400 dark:text-gray-500 font-medium">৳</span>
                            <input
                                v-model.number="minPrice"
                                type="number"
                                :min="prices.min_price || 0"
                                :max="maxPrice"
                                class="w-full border border-gray-300 dark:border-gray-600 rounded-lg pl-6 pr-2.5 py-1.5 text-sm text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 focus:outline-none focus:border-blue-500 dark:focus:border-blue-400 transition-colors"
                            >
                        </div>
                    </div>
                    <span class="text-gray-300 dark:text-gray-600 mt-5">—</span>
                    <div class="flex-1">
                        <label class="text-[10px] text-gray-400 dark:text-gray-500 uppercase tracking-wide font-medium">Max</label>
                        <div class="relative mt-1">
                            <span class="absolute left-2.5 top-1/2 -translate-y-1/2 text-xs text-gray-400 dark:text-gray-500 font-medium">৳</span>
                            <input
                                v-model.number="maxPrice"
                                type="number"
                                :min="minPrice"
                                :max="prices.max_price || 100000"
                                class="w-full border border-gray-300 dark:border-gray-600 rounded-lg pl-6 pr-2.5 py-1.5 text-sm text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 focus:outline-none focus:border-blue-500 dark:focus:border-blue-400 transition-colors"
                            >
                        </div>
                    </div>
                </div>
                <button
                    @click="applyPrice"
                    class="w-full text-xs font-semibold bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 text-white py-2 rounded-lg transition"
                >
                    Apply
                </button>
            </div>
        </div>
    </aside>
</template>

<style scoped>
.category-scroll::-webkit-scrollbar {
    width: 5px;
}
.category-scroll::-webkit-scrollbar-track {
    background: transparent;
}
.category-scroll::-webkit-scrollbar-thumb {
    background: #d1d5db;
    border-radius: 999px;
    border: 1px solid transparent;
    background-clip: content-box;
}
.category-scroll::-webkit-scrollbar-thumb:hover {
    background: #9ca3af;
    border: 1px solid transparent;
    background-clip: content-box;
}
:global(.dark) .category-scroll::-webkit-scrollbar-thumb {
    background: #4b5563;
    border: 1px solid transparent;
    background-clip: content-box;
}
:global(.dark) .category-scroll::-webkit-scrollbar-thumb:hover {
    background: #6b7280;
    border: 1px solid transparent;
    background-clip: content-box;
}
</style>
