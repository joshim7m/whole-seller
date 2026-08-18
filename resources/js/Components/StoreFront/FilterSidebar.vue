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
    <aside class="filter-sidebar h-full overflow-y-auto pr-1">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-[#D9531E] to-amber-400 flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75" />
                    </svg>
                </div>
                <h2 class="font-bold text-gray-900 dark:text-white text-sm tracking-wide">Filters</h2>
                <span v-if="activeFilterCount" class="min-w-[20px] h-5 flex items-center justify-center text-[10px] font-bold bg-[#D9531E] text-white px-1.5 rounded-full">{{ activeFilterCount }}</span>
            </div>
            <button v-if="activeFilterCount" @click="clearFilters" class="text-xs text-[#D9531E] dark:text-orange-400 hover:text-[#b84318] dark:hover:text-orange-300 font-semibold transition-colors">Clear all</button>
        </div>

        <div v-if="categories.length" class="mb-1">
            <button @click="categoryOpen = !categoryOpen" class="w-full flex items-center justify-between py-2.5 px-3 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors group">
                <span class="text-sm font-semibold text-gray-700 dark:text-gray-300 group-hover:text-gray-900 dark:group-hover:text-white">Category</span>
                <div class="flex items-center gap-1.5">
                    <span v-if="selectedCats.length" class="text-[10px] font-bold bg-[#D9531E]/10 text-[#D9531E] dark:text-orange-400 px-1.5 py-0.5 rounded-md">{{ selectedCats.length }}</span>
                    <svg class="w-4 h-4 text-gray-400 dark:text-gray-500 transition-transform duration-200" :class="{ 'rotate-180': categoryOpen }" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                </div>
            </button>
            <div v-show="categoryOpen" class="mt-1 ml-1 space-y-0.5 max-h-52 overflow-y-auto filter-scroll">
                <label v-for="cat in categories" :key="cat.id" class="flex items-center gap-2.5 cursor-pointer group rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800/50 px-2 py-1.5 transition-colors">
                    <span class="relative flex items-center justify-center w-4 h-4">
                        <input
                            type="checkbox"
                            :checked="selectedCats.includes(String(cat.id))"
                            @change="toggleCategory(cat.id)"
                            class="peer sr-only"
                        >
                        <span class="w-4 h-4 rounded border-2 border-gray-300 dark:border-gray-600 peer-checked:bg-[#D9531E] peer-checked:border-[#D9531E] dark:peer-checked:bg-orange-500 dark:peer-checked:border-orange-500 transition-all flex items-center justify-center">
                            <svg class="w-2.5 h-2.5 text-white opacity-0 peer-checked:opacity-100" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        </span>
                    </span>
                    <span class="text-sm text-gray-600 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-gray-200 transition-colors flex-1 truncate">{{ cat.name }}</span>
                    <span class="text-[11px] text-gray-400 dark:text-gray-600 font-medium bg-gray-100 dark:bg-gray-800 px-1.5 py-0.5 rounded-md">{{ cat.products_count || 0 }}</span>
                </label>
            </div>
        </div>

        <div v-if="sizes.length" class="mb-1">
            <button @click="sizeOpen = !sizeOpen" class="w-full flex items-center justify-between py-2.5 px-3 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors group">
                <span class="text-sm font-semibold text-gray-700 dark:text-gray-300 group-hover:text-gray-900 dark:group-hover:text-white">Size</span>
                <div class="flex items-center gap-1.5">
                    <span v-if="selectedSizes.length" class="text-[10px] font-bold bg-[#D9531E]/10 text-[#D9531E] dark:text-orange-400 px-1.5 py-0.5 rounded-md">{{ selectedSizes.length }}</span>
                    <svg class="w-4 h-4 text-gray-400 dark:text-gray-500 transition-transform duration-200" :class="{ 'rotate-180': sizeOpen }" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                </div>
            </button>
            <div v-show="sizeOpen" class="mt-1 ml-1 flex flex-wrap gap-1.5 px-1">
                <label v-for="size in sizes" :key="size" class="cursor-pointer">
                    <input
                        type="checkbox"
                        :checked="selectedSizes.includes(size)"
                        @change="toggleSize(size)"
                        class="sr-only peer"
                    >
                    <span class="inline-flex items-center justify-center min-w-[36px] px-2.5 py-1.5 text-xs font-medium rounded-lg border transition-all peer-checked:bg-gray-900 dark:peer-checked:bg-white peer-checked:text-white dark:peer-checked:text-gray-900 peer-checked:border-gray-900 dark:peer-checked:border-white peer-hover:border-gray-400 dark:peer-hover:border-gray-500 border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-400 bg-white dark:bg-gray-800">
                        {{ size }}
                    </span>
                </label>
            </div>
        </div>

        <div v-if="colors.length" class="mb-1">
            <button @click="colorOpen = !colorOpen" class="w-full flex items-center justify-between py-2.5 px-3 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors group">
                <span class="text-sm font-semibold text-gray-700 dark:text-gray-300 group-hover:text-gray-900 dark:group-hover:text-white">Color</span>
                <div class="flex items-center gap-1.5">
                    <span v-if="selectedColors.length" class="text-[10px] font-bold bg-[#D9531E]/10 text-[#D9531E] dark:text-orange-400 px-1.5 py-0.5 rounded-md">{{ selectedColors.length }}</span>
                    <svg class="w-4 h-4 text-gray-400 dark:text-gray-500 transition-transform duration-200" :class="{ 'rotate-180': colorOpen }" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                </div>
            </button>
            <div v-show="colorOpen" class="mt-1 ml-1 flex flex-wrap gap-2.5 px-1">
                <label v-for="color in colors" :key="color" class="cursor-pointer group flex flex-col items-center gap-1" :title="color">
                    <input
                        type="checkbox"
                        :checked="selectedColors.includes(color)"
                        @change="toggleColor(color)"
                        class="sr-only peer"
                    >
                    <span
                        class="w-8 h-8 rounded-full border-2 transition-all duration-200 peer-checked:scale-110 peer-checked:shadow-lg peer-checked:ring-2 peer-checked:ring-offset-2 peer-checked:ring-[#D9531E] dark:peer-checked:ring-offset-gray-900 group-hover:scale-105"
                        :style="{
                            backgroundColor: colorHex(color),
                            borderColor: color.toLowerCase() === 'white' || color.toLowerCase() === 'beige' || color.toLowerCase() === 'champagne' ? '#e5e7eb' : 'transparent'
                        }"
                    ></span>
                    <span class="text-[10px] text-gray-400 dark:text-gray-500 truncate max-w-[3.5rem] text-center leading-tight peer-checked:text-[#D9531E] dark:peer-checked:text-orange-400 transition-colors font-medium">{{ color }}</span>
                </label>
            </div>
        </div>

        <div v-if="prices" class="mb-1">
            <button @click="priceOpen = !priceOpen" class="w-full flex items-center justify-between py-2.5 px-3 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors group">
                <span class="text-sm font-semibold text-gray-700 dark:text-gray-300 group-hover:text-gray-900 dark:group-hover:text-white">Price Range</span>
                <svg class="w-4 h-4 text-gray-400 dark:text-gray-500 transition-transform duration-200" :class="{ 'rotate-180': priceOpen }" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
            </button>
            <div v-show="priceOpen" class="mt-1 ml-1 px-1 space-y-3">
                <div class="flex items-center gap-2">
                    <div class="flex-1">
                        <label class="text-[10px] text-gray-400 dark:text-gray-500 uppercase tracking-wider font-semibold">Min</label>
                        <div class="relative mt-1">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-xs text-gray-400 dark:text-gray-500 font-medium">&#2547;</span>
                            <input
                                v-model.number="minPrice"
                                type="number"
                                :min="prices.min_price || 0"
                                :max="maxPrice"
                                class="w-full border border-gray-200 dark:border-gray-700 rounded-lg pl-7 pr-2.5 py-2 text-sm text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 focus:outline-none focus:border-[#D9531E] dark:focus:border-orange-500 focus:ring-1 focus:ring-[#D9531E]/20 dark:focus:ring-orange-500/20 transition-all"
                            >
                        </div>
                    </div>
                    <span class="text-gray-300 dark:text-gray-600 mt-5 text-sm">&mdash;</span>
                    <div class="flex-1">
                        <label class="text-[10px] text-gray-400 dark:text-gray-500 uppercase tracking-wider font-semibold">Max</label>
                        <div class="relative mt-1">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-xs text-gray-400 dark:text-gray-500 font-medium">&#2547;</span>
                            <input
                                v-model.number="maxPrice"
                                type="number"
                                :min="minPrice"
                                :max="prices.max_price || 100000"
                                class="w-full border border-gray-200 dark:border-gray-700 rounded-lg pl-7 pr-2.5 py-2 text-sm text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 focus:outline-none focus:border-[#D9531E] dark:focus:border-orange-500 focus:ring-1 focus:ring-[#D9531E]/20 dark:focus:ring-orange-500/20 transition-all"
                            >
                        </div>
                    </div>
                </div>
                <button
                    @click="applyPrice"
                    class="w-full text-xs font-semibold bg-gradient-to-r from-[#D9531E] to-amber-500 hover:from-[#b84318] hover:to-amber-600 text-white py-2.5 rounded-lg transition-all shadow-sm hover:shadow-md"
                >
                    Apply Price
                </button>
            </div>
        </div>
    </aside>
</template>

<style scoped>
.filter-scroll::-webkit-scrollbar {
    width: 4px;
}
.filter-scroll::-webkit-scrollbar-track {
    background: transparent;
}
.filter-scroll::-webkit-scrollbar-thumb {
    background: #e5e7eb;
    border-radius: 999px;
}
.filter-scroll::-webkit-scrollbar-thumb:hover {
    background: #d1d5db;
}
:global(.dark) .filter-scroll::-webkit-scrollbar-thumb {
    background: #374151;
}
:global(.dark) .filter-scroll::-webkit-scrollbar-thumb:hover {
    background: #4b5563;
}

.filter-sidebar::-webkit-scrollbar {
    width: 3px;
}
.filter-sidebar::-webkit-scrollbar-track {
    background: transparent;
}
.filter-sidebar::-webkit-scrollbar-thumb {
    background: transparent;
    border-radius: 999px;
}
.filter-sidebar:hover::-webkit-scrollbar-thumb {
    background: #e5e7eb;
}
.filter-sidebar:hover::-webkit-scrollbar-thumb:hover {
    background: #d1d5db;
}
:global(.dark) .filter-sidebar:hover::-webkit-scrollbar-thumb {
    background: #374151;
}
:global(.dark) .filter-sidebar:hover::-webkit-scrollbar-thumb:hover {
    background: #4b5563;
}
</style>
