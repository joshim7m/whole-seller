<script setup>
import { Link, usePage } from '@inertiajs/vue3'
import { computed } from 'vue'

const props = defineProps({
    product: {
        type: Object,
        required: true
    },
    hideBadges: {
        type: Boolean,
        default: false
    },
    compact: {
        type: Boolean,
        default: false
    }
})

const page = usePage()
const isGuest = computed(() => !page.props.auth?.user)

const images = computed(() => props.product.images || [])
const firstImage = computed(() => images.value.length ? images.value[0]?.image_url || images.value[0]?.image_path || images.value[0]?.url : null)
const secondImage = computed(() => images.value.length > 1 ? images.value[1]?.image_url || images.value[1]?.image_path || images.value[1]?.url : null)
const salePrice = computed(() => Number(props.product.sale_price || props.product.unit_price || 0))
const originalPrice = computed(() => Number(props.product.unit_price || props.product.original_price || 0))
const hasDiscount = computed(() => originalPrice.value > salePrice.value)
const discountPct = computed(() => hasDiscount.value ? Math.round((1 - salePrice.value / originalPrice.value) * 100) : 0)

const merchantBadge = computed(() => props.product.merchant || props.product.division || null)

const colors = computed(() => {
    if (props.product.variants) {
        return [...new Set(props.product.variants.map(v => v.color).filter(Boolean))]
    }
    return props.product.colors || []
})

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
        'multi colour': 'linear-gradient(90deg, #ef4444, #3b82f6, #22c55e, #eab308)',
        multicolor: 'linear-gradient(90deg, #ef4444, #3b82f6, #22c55e, #eab308)',
        multicolour: 'linear-gradient(90deg, #ef4444, #3b82f6, #22c55e, #eab308)',
        multi: 'linear-gradient(90deg, #ef4444, #3b82f6, #22c55e, #eab308)',
        'baby pink': '#f4c2c2',
        'mint blue': '#a2d8d8',
    }
    return map[color.toLowerCase()] || '#d1d5db'
}
</script>

<template>
    <div class="group bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden shadow-sm hover:shadow-lg dark:hover:shadow-gray-900/40 transition-all duration-300 flex flex-col">
        <Link :href="route('product.show', product.slug || product.id)" :class="['block relative bg-gray-100 dark:bg-gray-700 overflow-hidden', compact ? 'aspect-[1/1]' : 'aspect-[3/4]']">
            <img
                v-if="firstImage"
                :src="firstImage"
                :alt="product.title"
                class="absolute inset-0 w-full h-full object-cover transition-opacity duration-500 group-hover:opacity-0"
                loading="lazy"
            >
            <img
                v-if="secondImage"
                :src="secondImage"
                :alt="product.title"
                class="absolute inset-0 w-full h-full object-cover opacity-0 group-hover:opacity-100 transition-opacity duration-500"
                loading="lazy"
            >
            <div v-if="!firstImage" class="absolute inset-0 flex items-center justify-center text-gray-300 dark:text-gray-600">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
                    <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>

            <span v-if="merchantBadge && isGuest" class="absolute top-1 left-1 bg-blue-600 text-white text-[9px] font-semibold px-1.5 py-0.5 rounded">{{ merchantBadge }}</span>

            <span v-if="!hideBadges && hasDiscount" class="absolute top-1 right-1 bg-red-500 text-white text-[9px] font-semibold px-1.5 py-0.5 rounded">-{{ discountPct }}%</span>
            <span v-if="!hideBadges && !hasDiscount" class="absolute top-1 right-1 bg-gradient-to-r from-orange-400 to-pink-500 text-white text-[9px] font-bold px-1.5 py-0.5 rounded-sm tracking-wider shadow-sm">SALE</span>
        </Link>

        <div :class="['flex flex-col flex-1', compact ? 'p-2' : 'p-3 md:p-3.5']">
            <Link :href="route('product.show', product.slug || product.id)" class="block">
                <h3 :class="['leading-snug line-clamp-2 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors', compact ? 'text-sm font-semibold text-gray-800 dark:text-gray-100' : 'text-xs md:text-sm font-semibold text-gray-800 dark:text-gray-100']">{{ product.title }}</h3>
            </Link>

            <div v-if="colors.length" :class="['flex items-center gap-1', compact ? 'mt-1' : 'mt-1.5']">
                <span
                    v-for="color in colors.slice(0, compact ? 3 : 5)" :key="color"
                    :class="['inline-block rounded-full border border-gray-200 dark:border-gray-600', compact ? 'w-2.5 h-2.5' : 'w-3.5 h-3.5']"
                    :style="{ backgroundColor: colorHex(color), backgroundImage: colorHex(color).startsWith('linear') ? colorHex(color) : 'none' }"
                ></span>
                <span v-if="colors.length > (compact ? 3 : 5)" class="text-[9px] text-gray-400 dark:text-gray-500 ml-0.5">+{{ colors.length - (compact ? 3 : 5) }}</span>
            </div>

            <div :class="['mt-auto', compact ? 'pt-1' : 'pt-2.5']">
                <div v-if="isGuest" class="font-bengali">
                    <Link :href="route('login')" :class="['font-medium text-blue-600 dark:text-blue-400 hover:underline leading-tight', compact ? 'text-xs' : 'text-xs md:text-sm']">
                        {{ 'প্রাইস দেখতে লগইন করুন' }}
                    </Link>
                </div>
                <div v-else class="flex items-center gap-2">
                    <span :class="['font-bold text-blue-600 dark:text-blue-400', compact ? 'text-sm' : 'text-sm md:text-base']">৳{{ salePrice.toLocaleString() }}</span>
                    <span v-if="hasDiscount" :class="['text-gray-400 dark:text-gray-500 line-through', compact ? 'text-xs' : 'text-[11px]']">৳{{ originalPrice.toLocaleString() }}</span>
                </div>
            </div>
        </div>

        <div v-if="isGuest" :class="['border-t border-gray-100 dark:border-gray-700 flex items-center justify-between', compact ? 'px-2 py-1.5' : 'px-3 py-2']">
            <Link :href="route('product.show', product.slug || product.id)" :class="['text-gray-500 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors', compact ? 'text-xs' : 'text-xs']">
                Details
            </Link>
            <Link :href="route('login')" :class="['font-medium text-blue-600 dark:text-blue-400 hover:underline', compact ? 'text-xs' : 'text-xs']">
                {{ 'কার্টে' }}
            </Link>
        </div>
    </div>
</template>
