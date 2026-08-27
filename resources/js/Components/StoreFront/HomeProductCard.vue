<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { computed, onMounted } from 'vue';
import { useWishlist } from '@/composables/useWishlist';

const props = defineProps({
    product: {
        type: Object,
        required: true,
    },
    index: {
        type: Number,
        default: 0,
    },
});

const page = usePage();
const isGuest = computed(() => !page.props.auth?.user);

const wishlist = useWishlist();
onMounted(() => wishlist.load());
const isWished = computed(() => wishlist.has(props.product.id));
function toggleWishlist() {
    wishlist.toggle(props.product.id);
}

const productUrl = computed(() =>
    route('product.show', props.product.slug || props.product.id),
);

const salePrice = computed(() =>
    Number(props.product.sale_price || props.product.unit_price || 0),
);
const originalPrice = computed(() =>
    Number(props.product.unit_price || props.product.original_price || 0),
);
const hasDiscount = computed(
    () => originalPrice.value > salePrice.value && originalPrice.value > 0,
);
const discountPct = computed(() =>
    hasDiscount.value
        ? Math.round((1 - salePrice.value / originalPrice.value) * 100)
        : 0,
);

const stock = computed(() =>
    Number(props.product.total_stock ?? props.product.quantity ?? 0),
);
const outOfStock = computed(() => stock.value <= 0);

const images = computed(() => (props.product.images || []).filter(Boolean));

const imageUrl = (img) => {
    if (!img) {
        return null;
    }

    if (typeof img === 'string') {
        return img;
    }

    return img.image_url || img.image_path || img.url || img.src || null;
};

const coverImage = computed(() => imageUrl(images.value[0]) || null);

const colors = computed(() => {
    if (props.product.variants) {
        return [
            ...new Set(
                props.product.variants.map((v) => v.color).filter(Boolean),
            ),
        ];
    }

    return props.product.colors || [];
});

const sizes = computed(() => {
    if (props.product.variants) {
        return [
            ...new Set(
                props.product.variants.map((v) => v.size).filter(Boolean),
            ),
        ];
    }

    return props.product.sizes || [];
});

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
        'multi colour':
            'linear-gradient(90deg, #ef4444, #3b82f6, #22c55e, #eab308)',
        multicolor:
            'linear-gradient(90deg, #ef4444, #3b82f6, #22c55e, #eab308)',
        multicolour:
            'linear-gradient(90deg, #ef4444, #3b82f6, #22c55e, #eab308)',
        multi: 'linear-gradient(90deg, #ef4444, #3b82f6, #22c55e, #eab308)',
        'baby pink': '#f4c2c2',
        'mint blue': '#a2d8d8',
    };

    return map[color.toLowerCase()] || '#d1d5db';
};

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
    <Link
        :href="productUrl"
        class="group relative flex flex-col rounded-[2rem] border border-gray-200/80 bg-white p-2.5 shadow-sm transition-all duration-300 hover:-translate-y-1.5 hover:border-orange-200 hover:shadow-2xl hover:shadow-orange-100/70 dark:border-gray-700 dark:bg-gray-800 dark:hover:border-gray-600 dark:hover:shadow-gray-900/60"
    >
        <span
            :class="accentFor(index)"
            class="absolute inset-x-10 top-0 h-1 rounded-b-full bg-gradient-to-r opacity-80"
        ></span>

        <div
            :class="backdropFor(index)"
            class="relative flex aspect-square items-center justify-center overflow-hidden rounded-[1.5rem] text-gray-300 dark:text-gray-600"
        >
            <img
                v-if="coverImage"
                :src="coverImage"
                :alt="product.title"
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

            <span
                v-if="hasDiscount"
                class="absolute left-2 top-2 z-10 rounded-full bg-gradient-to-r from-[#D9531E] to-rose-500 px-2 py-0.5 text-[10px] font-bold text-white shadow-sm"
                >-{{ discountPct }}%</span
            >

            <button
                type="button"
                @click.prevent.stop="toggleWishlist"
                :aria-label="isWished ? 'Remove from wishlist' : 'Add to wishlist'"
                :class="isWished ? 'text-red-500 bg-red-50 dark:bg-red-500/10' : 'text-gray-400 dark:text-gray-500 bg-white/80 dark:bg-gray-800/80 hover:text-red-500'"
                class="absolute top-2 right-2 z-10 w-8 h-8 rounded-full flex items-center justify-center transition shadow-sm"
            >
                <svg class="w-4 h-4" :fill="isWished ? 'currentColor' : 'none'" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
                </svg>
            </button>

            <div
                class="absolute inset-0 bg-gradient-to-t from-black/5 to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100"
            ></div>
        </div>

        <div class="flex flex-col gap-2 p-1 items-center pt-3">
            <div class="min-w-0">
                <h3
                    class="line-clamp-2 text-sm font-bold leading-snug text-[#0B132A] transition-colors group-hover:text-[#D9531E] dark:text-gray-100 dark:group-hover:text-orange-400 md:text-base"
                >
                    {{ product.title }}
                </h3>
            </div>

            <div
                v-if="colors.length || sizes.length"
                class="flex items-center justify-between gap-2"
            >
                <div v-if="colors.length" class="flex items-center gap-1">
                    <span
                        v-for="color in colors.slice(0, 4)"
                        :key="color"
                        class="inline-block h-3 w-3 rounded-full border border-gray-300 dark:border-gray-600"
                        :style="{
                            backgroundColor: colorHex(color),
                            backgroundImage: colorHex(color).startsWith(
                                'linear',
                            )
                                ? colorHex(color)
                                : 'none',
                        }"
                        :title="color"
                    ></span>
                    <span
                        v-if="colors.length > 4"
                        class="text-[10px] font-semibold text-gray-400 dark:text-gray-500"
                        >+{{ colors.length - 4 }}</span
                    >
                </div>
                <div
                    v-if="sizes.length"
                    class="flex flex-wrap items-center gap-1"
                >
                    <span
                        v-for="size in sizes"
                        :key="size"
                        class="inline-flex items-center rounded-full border border-orange-200 bg-orange-50 px-1.5 py-0.5 text-[10px] font-semibold text-orange-700 dark:border-gray-700 dark:bg-gray-700/50 dark:text-gray-300"
                        >{{ size }}</span
                    >
                </div>
            </div>

            <div
                class="mt-0.5 flex items-end justify-between gap-2 border-t border-gray-100 pt-2.5 dark:border-gray-800"
            >
                <div v-if="!isGuest" class="min-w-0">
                    <div class="flex items-baseline gap-1.5">
                        <span
                            class="text-sm font-extrabold tracking-tight text-[#D9531E] dark:text-orange-400 md:text-base"
                            >৳{{ salePrice.toLocaleString() }}</span
                        >
                        <span
                            v-if="hasDiscount"
                            class="text-[11px] font-medium text-red-300 line-through dark:text-red-500"
                            >৳{{ originalPrice.toLocaleString() }}</span
                        >
                    </div>
                </div>
                <div v-else class="min-w-0">
                    <Link
                        :href="route('login')"
                        class="text-[11px] font-medium text-blue-600 hover:underline dark:text-blue-400 sm:text-xs"
                        >প্রাইস দেখতে লগইন করুন</Link
                    >
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
        </div>
    </Link>
</template>
