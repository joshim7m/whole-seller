<script setup>
import { Autoplay } from 'swiper/modules';
import { Swiper, SwiperSlide } from 'swiper/vue';
import 'swiper/css';

const slides = [
    {
        image: 'https://images.pexels.com/photos/30703877/pexels-photo-30703877.jpeg?auto=compress&cs=tinysrgb&w=1920',
    },
    {
        image: 'https://images.pexels.com/photos/15751052/pexels-photo-15751052.jpeg?auto=compress&cs=tinysrgb&w=1920',
    },
    {
        image: 'https://images.pexels.com/photos/35618862/pexels-photo-35618862.jpeg?auto=compress&cs=tinysrgb&w=1920',
    },
    {
        image: 'https://images.pexels.com/photos/10411933/pexels-photo-10411933.jpeg?auto=compress&cs=tinysrgb&w=1920',
    },
];

const modules = [Autoplay];
</script>

<template>
    <section
        class="relative mb-16 select-none"
        role="region"
        aria-label="Hero slideshow"
    >
        <Swiper
            :modules="modules"
            :loop="true"
            :autoplay="{
                delay: 5000,
                disableOnInteraction: false,
            }"
            class="swiper-custom overflow-hidden rounded-2xl aspect-[16/9]"
        >
            <SwiperSlide
                v-for="(s, i) in slides"
                :key="i"
                class="relative h-full w-full"
            >
                <img
                    :src="s.image"
                    :alt="'Hero slide ' + (i + 1)"
                    class="absolute inset-0 h-full w-full object-cover"
                    loading="lazy"
                    draggable="false"
                />
            </SwiperSlide>
        </Swiper>
    </section>
</template>
