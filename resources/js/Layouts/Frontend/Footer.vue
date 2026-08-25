<script setup>
import { ref, onMounted, onUnmounted, computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import { useWishlist } from '@/composables/useWishlist';

const page = usePage();
const settings = page.props.settings || {};
const socialMedias = page.props.socialMedias || [];
const pages = page.props.pages || [];
const auth = page.props.auth;

const wishlist = useWishlist();
wishlist.load();
const wishlistCount = computed(() => wishlist.ids.value.length);

const companyName = settings.company_name || 'Store';
const companyDescription = settings.company_description || '';
const companyEmail = settings.company_email || '';
const companyMobile = settings.company_mobile || '';
const companyAddress = settings.company_address || '';
const companyWorkingHours = settings.company_working_hours || '';
const companyLogo = settings.company_logo;

const year = new Date().getFullYear();

const openSection = ref(null);
const isDesktop = ref(false);

function toggle(section) {
    openSection.value = openSection.value === section ? null : section;
}

const mql =
    typeof window !== 'undefined'
        ? window.matchMedia('(min-width: 768px)')
        : null;

function checkDesktop() {
    isDesktop.value = mql ? mql.matches : false;
}

onMounted(() => {
    checkDesktop();
    if (mql) mql.addEventListener('change', checkDesktop);
});

onUnmounted(() => {
    if (mql) mql.removeEventListener('change', checkDesktop);
});
</script>

<template>
    <footer class="bg-[#0B132A] text-gray-400">
        <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 md:py-14">
            <div class="grid grid-cols-1 gap-8 text-center sm:grid-cols-2 sm:text-left lg:grid-cols-12 lg:gap-10">

                <div class="sm:col-span-2 lg:col-span-5">
                    <Link :href="route('home')" class="inline-flex items-center gap-3">
                        <img v-if="companyLogo" :src="`/${companyLogo}`" :alt="companyName" class="h-8 w-auto sm:h-9" />
                        <span v-else class="text-xl font-bold tracking-tight text-white">{{ companyName }}</span>
                    </Link>
                    <p v-if="companyDescription" class="mt-4 mx-auto max-w-sm text-sm leading-relaxed text-gray-400 sm:mx-0">{{ companyDescription }}</p>

                    <div v-if="socialMedias.length" class="mt-6 flex items-center justify-center gap-2.5 sm:justify-start">
                        <a
                            v-for="sm in socialMedias"
                            :key="sm.id"
                            :href="sm.url"
                            target="_blank"
                            rel="noopener noreferrer"
                            :aria-label="sm.name"
                            class="flex h-10 w-10 items-center justify-center rounded-full bg-white/5 text-gray-400 transition-all duration-300 hover:bg-[#D9531E] hover:text-white hover:scale-110 hover:shadow-lg hover:shadow-[#D9531E]/25"
                        >
                            <span v-if="sm.icon_svg" v-html="sm.icon_svg" class="flex h-4 w-4 items-center justify-center [&>svg]:h-4 [&>svg]:w-4 [&>svg]:fill-current"></span>
                            <span v-else class="text-xs font-bold uppercase">{{ sm.icon }}</span>
                        </a>
                    </div>

                </div>

                <div class="lg:col-span-2">
                    <button @click="toggle('information')" class="flex w-full items-center justify-center gap-2 py-2 text-left md:cursor-default md:justify-start">
                        <h3 class="text-sm font-bold uppercase tracking-wider text-white">Information</h3>
                        <svg class="h-4 w-4 text-gray-500 transition-transform md:hidden" :class="{ 'rotate-180': openSection === 'information' }" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                    </button>
                    <div v-show="isDesktop || openSection === 'information'" class="mt-3 pb-4 md:pb-0">
                        <ul class="space-y-2.5 text-center md:text-left">
                            <li v-for="p in pages" :key="p.id">
                                <Link :href="route('pages.show', p.slug)" class="text-sm text-gray-400 transition hover:text-[#D9531E]">{{ p.title }}</Link>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="lg:col-span-2">
                    <button @click="toggle('support')" class="flex w-full items-center justify-center gap-2 py-2 text-left md:cursor-default md:justify-start">
                        <h3 class="text-sm font-bold uppercase tracking-wider text-white">Support</h3>
                        <svg class="h-4 w-4 text-gray-500 transition-transform md:hidden" :class="{ 'rotate-180': openSection === 'support' }" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                    </button>
                    <div v-show="isDesktop || openSection === 'support'" class="mt-3 pb-4 md:pb-0">
                        <ul class="space-y-2.5 text-center md:text-left">
                            <li><a href="#" class="text-sm text-gray-400 transition hover:text-[#D9531E]">Contact Us</a></li>
                            <li><a href="#" class="text-sm text-gray-400 transition hover:text-[#D9531E]">Shipping &amp; Returns</a></li>
                            <li><a href="#" class="text-sm text-gray-400 transition hover:text-[#D9531E]">FAQs</a></li>
                            <li><a href="#" class="text-sm text-gray-400 transition hover:text-[#D9531E]">Size Guide</a></li>
                        </ul>
                    </div>
                </div>

                <div class="sm:col-span-2 lg:col-span-3">
                    <h3 class="mb-4 text-sm font-bold uppercase tracking-wider text-white text-center md:text-left">Address</h3>
                    <div class="space-y-3">
                        <a v-if="companyAddress" href="#" class="flex items-start gap-3 rounded-xl bg-white/5 p-3 transition hover:bg-white/10 md:p-0 md:bg-transparent">
                            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-[#D9531E]/10 text-[#D9531E]">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </span>
                            <span class="text-sm leading-relaxed text-gray-400">{{ companyAddress }}</span>
                        </a>
                        <a v-if="companyMobile" :href="`tel:${companyMobile}`" class="flex items-start gap-3 rounded-xl bg-white/5 p-3 transition hover:bg-white/10 md:p-0 md:bg-transparent">
                            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-[#D9531E]/10 text-[#D9531E]">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            </span>
                            <div>
                                <span class="text-[11px] font-medium uppercase tracking-wider text-gray-500">Phone</span>
                                <p class="text-sm text-gray-400">{{ companyMobile }}</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="border-t border-white/5">
            <div class="mx-auto flex max-w-7xl flex-col items-center justify-between gap-3 px-4 py-5 sm:flex-row md:px-6">
                <p class="text-xs text-gray-500">&copy; {{ year }} {{ companyName }}. All rights reserved.</p>
                <div class="flex items-center gap-3 text-xs text-gray-500">
                    <template v-for="(p, i) in pages" :key="p.id">
                        <Link :href="route('pages.show', p.slug)" class="transition hover:text-gray-300">{{ p.title }}</Link>
                        <span v-if="i < pages.length - 1" class="text-gray-700">|</span>
                    </template>
                </div>
            </div>
        </div>
    </footer>

    <nav class="fixed bottom-0 left-0 right-0 z-40 flex h-16 items-center justify-around border-t border-gray-200 bg-white shadow-[0_-2px_10px_rgba(0,0,0,0.08)] dark:border-gray-800 dark:bg-gray-900 dark:shadow-[0_-2px_10px_rgba(0,0,0,0.3)] md:hidden">
        <Link :href="route('home')" class="relative flex flex-col items-center gap-0.5 text-gray-500 transition hover:text-[#D9531E] dark:text-gray-400 dark:hover:text-orange-400">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
            <span class="text-[10px] font-medium">Home</span>
        </Link>
        <Link :href="route('categories.index')" class="flex flex-col items-center gap-0.5 text-gray-500 transition hover:text-[#D9531E] dark:text-gray-400 dark:hover:text-orange-400">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
            <span class="text-[10px] font-medium">Categories</span>
        </Link>
        <Link :href="route('wishlist.index')" class="relative flex flex-col items-center gap-0.5 text-gray-500 transition hover:text-red-500 dark:text-gray-400 dark:hover:text-red-400" aria-label="Wishlist">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" /></svg>
            <span class="text-[10px] font-medium">Wishlist</span>
            <span v-if="wishlistCount" class="absolute right-[calc(50%-22px)] top-0 flex h-4 min-w-[16px] items-center justify-center rounded-full bg-red-500 px-1 text-[10px] font-bold leading-none text-white">{{ wishlistCount }}</span>
        </Link>
        <Link v-if="auth?.user" :href="route('orders.index')" class="flex flex-col items-center gap-0.5 text-gray-500 transition hover:text-[#D9531E] dark:text-gray-400 dark:hover:text-orange-400">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
            <span class="text-[10px] font-medium">Profile</span>
        </Link>
        <Link v-else :href="route('login')" class="flex flex-col items-center gap-0.5 text-gray-500 transition hover:text-[#D9531E] dark:text-gray-400 dark:hover:text-orange-400">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
            <span class="text-[10px] font-medium">Account</span>
        </Link>
    </nav>

    <div class="h-16 md:hidden"></div>
</template>
