<script setup>
import { Head, usePage } from '@inertiajs/vue3'
import FrontEndMaster from '@/Layouts/Frontend/FrontEndMaster.vue'
import HeroSlider from '@/Components/StoreFront/HeroSlider.vue'
import CategoryGrid from '@/Components/StoreFront/CategoryGrid.vue'
import NewArrivalsProducts from '@/Components/StoreFront/NewArrivalsProducts.vue'
import TopSellingProducts from '@/Components/StoreFront/TopSellingProducts.vue'
import InstagramGallery from '@/Components/StoreFront/InstagramGallery.vue'
import NoticeSection from '@/Components/StoreFront/NoticeSection.vue'
import FaqSection from '@/Components/StoreFront/FaqSection.vue'

defineProps({
    categories: { type: Array, default: () => [] },
    products: { type: Array, default: () => [] },
    newArrivals: { type: Array, default: () => [] },
    instagramImages: { type: Array, default: () => [] },
    faqs: { type: Array, default: () => [] },
    notices: { type: Array, default: () => [] }
})

const page = usePage()
const settings = page.props.settings || {}
</script>

<template>
    <Head title="Home" />

    <FrontEndMaster>
        <HeroSlider />

        <CategoryGrid :categories="categories" />

        <NewArrivalsProducts :products="newArrivals" />

        <TopSellingProducts :products="products" />

        <InstagramGallery :instagramImages="instagramImages" />

        <NoticeSection :notices="notices" />

        <FaqSection :faqs="faqs" />
    </FrontEndMaster>
</template>
