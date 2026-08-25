<script setup>
import { ref, computed } from 'vue'
import { Link, router } from '@inertiajs/vue3'

const props = defineProps({
    filters: {
        type: Object,
        default: () => ({})
    }
})

const categories = computed(() => props.filters.categories || [])
const sizes = computed(() => props.filters.sizes || [])
const colors = computed(() => props.filters.colors || [])

const urlParams = computed(() => new URL(window.location.href).searchParams)

const selectedSizes = computed(() => urlParams.value.getAll('sizes'))
const selectedColors = computed(() => urlParams.value.getAll('colors'))
const qParam = computed(() => urlParams.value.get('q'))

const sizeOpen = ref(true)
const colorOpen = ref(true)
const priceOpen = ref(true)

const minPrice = ref(200)
const maxPrice = ref(2000)

const activeFilterCount = computed(() => {
    let count = 0
    count += selectedSizes.value.length
    count += selectedColors.value.length
    if (urlParams.value.get('min_price')) count++
    if (urlParams.value.get('max_price')) count++
    return count
})

function submitForm() {
    const params = new URLSearchParams()
    if (qParam.value) params.set('q', qParam.value)

    for (const size of selectedSizes.value) {
        params.append('sizes', size)
    }
    for (const color of selectedColors.value) {
        params.append('colors', color)
    }
    if (minPrice.value > 200) {
        params.set('min_price', minPrice.value)
    }
    if (maxPrice.value < 2000) {
        params.set('max_price', maxPrice.value)
    }

    const qs = params.toString()
    const url = window.location.pathname + (qs ? '?' + qs : '')
    router.get(url, {}, { preserveScroll: true, preserveState: true })
}

function clearFilters() {
    router.get(window.location.pathname, {}, { preserveScroll: true, preserveState: true })
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
    <aside class="h-full overflow-y-auto">
        <div class="flex items-center justify-between mb-5">
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

        <div v-if="categories.length" class="mb-5">
            <h3 class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-3 px-1">Category</h3>
            <div class="">
                <Link
                    v-for="cat in categories"
                    :key="cat.id"
                    :href="route('category.show', cat.slug || cat.id)"
                    class="flex items-center justify-between px-3 py-1.5 rounded-xl text-sm transition-all"
                    :class="urlParams.get('categories')?.includes(String(cat.id))
                        ? 'bg-[#D9531E] text-white font-semibold shadow-sm'
                        : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-white'"
                >
                    <span class="truncate">{{ cat.name }}</span>
                    <span
                        class="text-[11px] font-medium px-2 py-0.5 rounded-full"
                        :class="urlParams.get('categories')?.includes(String(cat.id))
                            ? 'bg-white/20 text-white'
                            : 'bg-gray-100 dark:bg-gray-800 text-gray-500 dark:text-gray-500'"
                    >{{ cat.products_count || 0 }}</span>
                </Link>
            </div>
        </div>

        <div v-if="sizes.length" class="mb-5">
            <button @click="sizeOpen = !sizeOpen" class="w-full flex items-center justify-between mb-3 px-1">
                <span class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Size</span>
                <svg class="w-4 h-4 text-gray-400 dark:text-gray-500 transition-transform duration-200" :class="{ 'rotate-180': sizeOpen }" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
            </button>
            <div v-show="sizeOpen" class="flex flex-wrap gap-1.5">
                <button
                    v-for="size in sizes"
                    :key="size"
                    @click="toggleSize(size)"
                    class="inline-flex items-center justify-center min-w-[36px] px-2.5 py-1.5 text-xs font-medium rounded-lg border transition-all"
                    :class="selectedSizes.includes(size)
                        ? 'bg-[#D9531E] border-[#D9531E] text-white shadow-sm'
                        : 'border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-400 bg-white dark:bg-gray-800 hover:border-gray-400 dark:hover:border-gray-500'"
                >{{ size }}</button>
            </div>
        </div>

        <div v-if="colors.length" class="mb-5">
            <button @click="colorOpen = !colorOpen" class="w-full flex items-center justify-between mb-3 px-1">
                <span class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Color</span>
                <svg class="w-4 h-4 text-gray-400 dark:text-gray-500 transition-transform duration-200" :class="{ 'rotate-180': colorOpen }" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
            </button>
            <div v-show="colorOpen" class="flex flex-wrap gap-2.5">
                <button
                    v-for="color in colors"
                    :key="color"
                    @click="toggleColor(color)"
                    class="group flex flex-col items-center gap-1"
                    :title="color"
                >
                    <span
                        class="w-8 h-8 rounded-full border-2 transition-all duration-200 hover:scale-110"
                        :class="selectedColors.includes(color)
                            ? 'scale-110 shadow-lg ring-2 ring-offset-2 ring-[#D9531E] dark:ring-offset-gray-900'
                            : ''"
                        :style="{
                            backgroundColor: colorHex(color),
                            borderColor: color.toLowerCase() === 'white' || color.toLowerCase() === 'beige' || color.toLowerCase() === 'champagne' ? '#e5e7eb' : 'transparent'
                        }"
                    ></span>
                    <span
                        class="text-[10px] truncate max-w-[3.5rem] text-center leading-tight font-medium transition-colors"
                        :class="selectedColors.includes(color)
                            ? 'text-[#D9531E] dark:text-orange-400'
                            : 'text-gray-400 dark:text-gray-500'"
                    >{{ color }}</span>
                </button>
            </div>
        </div>

        <div class="mb-1">
            <button @click="priceOpen = !priceOpen" class="w-full flex items-center justify-between mb-3 px-1">
                <span class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Price Range</span>
                <svg class="w-4 h-4 text-gray-400 dark:text-gray-500 transition-transform duration-200" :class="{ 'rotate-180': priceOpen }" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
            </button>
            <div v-show="priceOpen" class="space-y-3">
                <div class="flex items-center gap-2">
                    <div class="flex-1">
                        <label class="text-[10px] text-gray-400 dark:text-gray-500 uppercase tracking-wider font-semibold">Min</label>
                        <div class="relative mt-1">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-xs text-gray-400 dark:text-gray-500 font-medium">&#2547;</span>
                            <input
                                v-model.number="minPrice"
                                type="number"
                                min="0"
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
                                max="100000"
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
