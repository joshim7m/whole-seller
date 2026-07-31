<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import { Link } from '@inertiajs/vue3'

const slides = [
    {
        image: 'https://images.pexels.com/photos/30703877/pexels-photo-30703877.jpeg?auto=compress&cs=tinysrgb&w=1920',
        title: 'Discover Traditional Elegance',
        subtitle: 'Curated collections blending heritage with modern style for the fashion-forward.',
        cta: 'Explore Collection',
        ctaLink: route('products.index'),
    },
    {
        image: 'https://images.pexels.com/photos/15751052/pexels-photo-15751052.jpeg?auto=compress&cs=tinysrgb&w=1920',
        title: 'Modest Fashion, Bold Style',
        subtitle: 'Express yourself with our latest modest wear collection, designed for confidence.',
        cta: 'Shop Now',
        ctaLink: route('products.index'),
    },
    {
        image: 'https://images.pexels.com/photos/35618862/pexels-photo-35618862.jpeg?auto=compress&cs=tinysrgb&w=1920',
        title: 'Glamorous Nights',
        subtitle: 'Stand out with our premium evening wear, crafted for unforgettable moments.',
        cta: 'Shop Evening Wear',
        ctaLink: route('products.index'),
    },
    {
        image: 'https://images.pexels.com/photos/10411933/pexels-photo-10411933.jpeg?auto=compress&cs=tinysrgb&w=1920',
        title: 'Sharp & Sophisticated',
        subtitle: 'Elevate your everyday look with our curated men\'s collection.',
        cta: 'Shop Men\'s Fashion',
        ctaLink: route('products.index'),
    },
]

const slide = ref(0)
let interval = null

function goTo(i) {
    slide.value = i
}

function prev() {
    slide.value = slide.value > 0 ? slide.value - 1 : 0
}

function next() {
    slide.value = slide.value < slides.length - 1 ? slide.value + 1 : slides.length - 1
}

onMounted(() => {
    interval = setInterval(() => {
        slide.value = slide.value < slides.length - 1 ? slide.value + 1 : slides.length - 1
    }, 5000)
})

onUnmounted(() => {
    if (interval) clearInterval(interval)
})
</script>

<template>
    <section class="relative overflow-hidden rounded-2xl mb-16 bg-gray-900 select-none" role="region" aria-label="Hero slideshow">
        <div
            :style="{ transform: 'translateX(-' + (slide * 100) + '%)' }"
            class="flex transition-transform duration-700 ease-in-out will-change-transform"
        >
            <div v-for="(s, i) in slides" :key="i" class="w-full flex-shrink-0 relative h-[400px] md:h-[500px] lg:h-[560px]">
                <img :src="s.image" :alt="s.title" class="absolute inset-0 w-full h-full object-cover" loading="lazy">
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-black/10"></div>
                <div class="absolute inset-0 bg-gradient-to-r from-black/50 via-transparent to-transparent"></div>
                <div class="relative z-10 flex items-center h-full px-6 md:px-10 lg:px-14">
                    <div class="max-w-lg">
                        <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white leading-tight">{{ s.title }}</h1>
                        <p class="mt-3 text-white/80 text-sm md:text-base lg:text-lg max-w-md">{{ s.subtitle }}</p>
                        <Link :href="s.ctaLink" class="mt-6 inline-flex items-center gap-2 bg-yellow-400 text-gray-900 font-semibold px-7 py-3 rounded-lg text-sm md:text-base hover:opacity-90 transition hover:shadow-lg hover:shadow-yellow-500/25">{{ s.cta }}</Link>
                    </div>
                </div>
            </div>
        </div>

        <div class="absolute bottom-5 left-1/2 -translate-x-1/2 flex gap-2.5 z-20">
            <button
                v-for="(s, i) in slides" :key="i"
                @click="goTo(i)"
                class="w-2.5 h-2.5 rounded-full transition-all duration-300"
                :class="slide === i ? 'bg-white w-6' : 'bg-white/40 hover:bg-white/60'"
                :aria-label="'Go to slide ' + (i + 1)"
            ></button>
        </div>

        <button
            @click="prev()"
            class="absolute left-3 top-1/2 -translate-y-1/2 z-20 w-10 h-10 rounded-full bg-white/15 hover:bg-white/30 text-white flex items-center justify-center transition backdrop-blur-sm hover:scale-110 disabled:opacity-30 disabled:cursor-not-allowed"
            :disabled="slide === 0"
            aria-label="Previous slide"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
        </button>
        <button
            @click="next()"
            class="absolute right-3 top-1/2 -translate-y-1/2 z-20 w-10 h-10 rounded-full bg-white/15 hover:bg-white/30 text-white flex items-center justify-center transition backdrop-blur-sm hover:scale-110 disabled:opacity-30 disabled:cursor-not-allowed"
            :disabled="slide === slides.length - 1"
            aria-label="Next slide"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
        </button>
    </section>
</template>
