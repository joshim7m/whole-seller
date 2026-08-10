<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { Link } from '@inertiajs/vue3';

const slides = [
    {
        image: 'https://images.pexels.com/photos/30703877/pexels-photo-30703877.jpeg?auto=compress&cs=tinysrgb&w=1920',
        title: 'Discover Traditional Elegance',
        subtitle:
            'Curated collections blending heritage with modern style for the fashion-forward.',
        cta: 'Explore Collection',
        ctaLink: route('products.index'),
    },
    {
        image: 'https://images.pexels.com/photos/15751052/pexels-photo-15751052.jpeg?auto=compress&cs=tinysrgb&w=1920',
        title: 'Modest Fashion, Bold Style',
        subtitle:
            'Express yourself with our latest modest wear collection, designed for confidence.',
        cta: 'Shop Now',
        ctaLink: route('products.index'),
    },
    {
        image: 'https://images.pexels.com/photos/35618862/pexels-photo-35618862.jpeg?auto=compress&cs=tinysrgb&w=1920',
        title: 'Glamorous Nights',
        subtitle:
            'Stand out with our premium evening wear, crafted for unforgettable moments.',
        cta: 'Shop Evening Wear',
        ctaLink: route('products.index'),
    },
    {
        image: 'https://images.pexels.com/photos/10411933/pexels-photo-10411933.jpeg?auto=compress&cs=tinysrgb&w=1920',
        title: 'Sharp & Sophisticated',
        subtitle:
            "Elevate your everyday look with our curated men's collection.",
        cta: "Shop Men's Fashion",
        ctaLink: route('products.index'),
    },
];

const slide = ref(0);
let interval = null;

const track = ref(null);
const dragging = ref(false);
const startX = ref(0);
const startY = ref(0);
const dragOffset = ref(0);

const trackWidth = () => track.value?.offsetWidth || 1;

function goTo(i) {
    slide.value = i;
}

function startAutoPlay() {
    stopAutoPlay();
    interval = setInterval(() => {
        slide.value =
            slide.value < slides.length - 1
                ? slide.value + 1
                : slides.length - 1;
    }, 5000);
}

function stopAutoPlay() {
    if (interval) clearInterval(interval);
    interval = null;
}

function startDrag(e) {
    stopAutoPlay();
    dragging.value = false;
    startX.value = e.touches[0].clientX;
    startY.value = e.touches[0].clientY;
    dragOffset.value = 0;
}

function onDrag(e) {
    const dx = e.touches[0].clientX - startX.value;
    const dy = e.touches[0].clientY - startY.value;

    if (!dragging.value) {
        if (Math.abs(dx) < 6) return;
        if (Math.abs(dy) > Math.abs(dx)) return;
        dragging.value = true;
    }

    dragOffset.value = dx;
}

function endDrag() {
    if (dragging.value) {
        const threshold = Math.max(60, trackWidth() * 0.12);

        if (dragOffset.value <= -threshold && slide.value < slides.length - 1) {
            slide.value += 1;
        } else if (dragOffset.value >= threshold && slide.value > 0) {
            slide.value -= 1;
        }
    }

    dragging.value = false;
    dragOffset.value = 0;
    startAutoPlay();
}

onMounted(startAutoPlay);
onUnmounted(stopAutoPlay);
</script>

<template>
    <section
        class="relative mb-16 touch-pan-y select-none overflow-hidden rounded-2xl bg-gray-900"
        role="region"
        aria-label="Hero slideshow"
        @touchstart.passive="startDrag"
        @touchmove.passive="onDrag"
        @touchend="endDrag"
        @touchcancel="endDrag"
    >
        <div
            :style="{
                transform:
                    'translateX(calc(-' +
                    slide * 100 +
                    '% + ' +
                    dragOffset +
                    'px))',
            }"
            :class="
                dragging
                    ? 'flex will-change-transform'
                    : 'flex transition-transform duration-700 ease-in-out will-change-transform'
            "
            ref="track"
        >
            <div
                v-for="(s, i) in slides"
                :key="i"
                class="relative h-[400px] w-full flex-shrink-0 md:h-[500px] lg:h-[560px]"
            >
                <img
                    :src="s.image"
                    :alt="s.title"
                    class="absolute inset-0 h-full w-full object-cover"
                    loading="lazy"
                    draggable="false"
                />
                <div
                    class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-black/10"
                ></div>
                <div
                    class="absolute inset-0 bg-gradient-to-r from-black/50 via-transparent to-transparent"
                ></div>
                <div
                    class="relative z-10 flex h-full items-center px-6 md:px-10 lg:px-14"
                >
                    <div class="max-w-lg">
                        <h1
                            class="text-3xl font-bold leading-tight text-white md:text-4xl lg:text-5xl"
                        >
                            {{ s.title }}
                        </h1>
                        <p
                            class="mt-3 max-w-md text-sm text-white/80 md:text-base lg:text-lg"
                        >
                            {{ s.subtitle }}
                        </p>
                        <Link
                            :href="s.ctaLink"
                            class="mt-6 inline-flex items-center gap-2 rounded-lg bg-yellow-400 px-7 py-3 text-sm font-semibold text-gray-900 transition hover:opacity-90 hover:shadow-lg hover:shadow-yellow-500/25 md:text-base"
                            >{{ s.cta }}</Link
                        >
                    </div>
                </div>
            </div>
        </div>

        <div
            class="absolute bottom-5 left-1/2 z-20 flex -translate-x-1/2 gap-2.5"
        >
            <button
                v-for="(s, i) in slides"
                :key="i"
                @click="goTo(i)"
                class="h-2.5 w-2.5 rounded-full transition-all duration-300"
                :class="
                    slide === i
                        ? 'w-6 bg-white'
                        : 'bg-white/40 hover:bg-white/60'
                "
                :aria-label="'Go to slide ' + (i + 1)"
            ></button>
        </div>
    </section>
</template>
