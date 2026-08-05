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
const fbHandler = settings.facebook_handler;
const igHandler = settings.instagram_handler;

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
    <footer class="bg-gray-900 text-gray-300 dark:bg-gray-950">
        <div class="mx-auto max-w-7xl px-4 py-10 md:px-6 md:py-14">
            <div
                class="grid grid-cols-1 gap-0 md:grid-cols-2 md:gap-8 lg:grid-cols-12 lg:gap-12"
            >
                <div
                    class="mb-6 border-b border-gray-800 pb-6 md:mb-0 md:border-0 md:pb-0 lg:col-span-4"
                >
                    <Link
                        :href="route('home')"
                        class="inline-flex items-center gap-3"
                    >
                        <img
                            v-if="companyLogo"
                            :src="`/${companyLogo}`"
                            :alt="companyName"
                            class="h-9 w-auto brightness-0 invert"
                        />
                        <span
                            v-else
                            class="text-xl font-bold tracking-tight text-white"
                            >{{ companyName }}</span
                        >
                    </Link>
                    <p
                        class="mt-3 max-w-xs text-sm leading-relaxed text-gray-400"
                    >
                        {{ companyDescription }}
                    </p>
                    <div class="mt-4 flex items-center gap-3">
                        <a
                            v-for="sm in socialMedias"
                            :key="sm.id"
                            :href="sm.url"
                            class="flex h-9 w-9 items-center justify-center rounded-full bg-gray-800 text-gray-400 transition hover:bg-gray-700 hover:text-white"
                            :aria-label="sm.name"
                            target="_blank"
                        >
                            <span
                                v-if="sm.icon_svg"
                                v-html="sm.icon_svg"
                                class="flex h-4 w-4 items-center justify-center"
                            ></span>
                            <span v-else class="font-mono text-xs">{{
                                sm.icon
                            }}</span>
                        </a>
                        <a
                            v-if="fbHandler"
                            :href="'https://facebook.com/' + fbHandler"
                            class="flex h-9 w-9 items-center justify-center rounded-full bg-gray-800 text-gray-400 transition hover:bg-gray-700 hover:text-white"
                            aria-label="Facebook"
                            target="_blank"
                        >
                            <svg
                                class="h-4 w-4"
                                fill="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"
                                />
                            </svg>
                        </a>
                        <a
                            v-if="igHandler"
                            :href="'https://instagram.com/' + igHandler"
                            class="flex h-9 w-9 items-center justify-center rounded-full bg-gray-800 text-gray-400 transition hover:bg-gray-700 hover:text-white"
                            aria-label="Instagram"
                            target="_blank"
                        >
                            <svg
                                class="h-4 w-4"
                                fill="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"
                                />
                            </svg>
                        </a>
                    </div>
                </div>

                <div class="border-b border-gray-800 md:border-0 lg:col-span-2">
                    <button
                        @click="toggle('quick')"
                        class="flex w-full items-center justify-between py-4 text-left md:cursor-default md:py-0"
                    >
                        <h3
                            class="text-sm font-semibold uppercase tracking-wider text-white"
                        >
                            Quick Links
                        </h3>
                        <svg
                            class="h-4 w-4 text-gray-500 transition-transform md:hidden"
                            :class="{ 'rotate-180': openSection === 'quick' }"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M19 9l-7 7-7-7"
                            />
                        </svg>
                    </button>
                    <div
                        v-show="isDesktop || openSection === 'quick'"
                        class="pb-4 md:pb-0"
                    >
                        <ul class="space-y-2.5">
                            <li>
                                <Link
                                    :href="route('home')"
                                    class="text-sm text-gray-400 transition hover:text-white"
                                    >Home</Link
                                >
                            </li>
                            <li>
                                <Link
                                    :href="route('products.index')"
                                    class="text-sm text-gray-400 transition hover:text-white"
                                    >Shop All</Link
                                >
                            </li>
                            <li>
                                <Link
                                    :href="route('products.new-arrivals')"
                                    class="text-sm text-gray-400 transition hover:text-white"
                                    >New Arrivals</Link
                                >
                            </li>
                            <li>
                                <Link
                                    :href="route('products.hot-sale')"
                                    class="text-sm text-gray-400 transition hover:text-white"
                                    >Hot Sale</Link
                                >
                            </li>
                            <li>
                                <Link
                                    :href="route('categories.index')"
                                    class="text-sm text-gray-400 transition hover:text-white"
                                    >Categories</Link
                                >
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="border-b border-gray-800 md:border-0 lg:col-span-2">
                    <button
                        @click="toggle('information')"
                        class="flex w-full items-center justify-between py-4 text-left md:cursor-default md:py-0"
                    >
                        <h3
                            class="text-sm font-semibold uppercase tracking-wider text-white"
                        >
                            Information
                        </h3>
                        <svg
                            class="h-4 w-4 text-gray-500 transition-transform md:hidden"
                            :class="{
                                'rotate-180': openSection === 'information',
                            }"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M19 9l-7 7-7-7"
                            />
                        </svg>
                    </button>
                    <div
                        v-show="isDesktop || openSection === 'information'"
                        class="pb-4 md:pb-0"
                    >
                        <ul class="space-y-2.5">
                            <li v-for="p in pages" :key="p.id">
                                <Link
                                    :href="route('pages.show', p.slug)"
                                    class="text-sm text-gray-400 transition hover:text-white"
                                    >{{ p.title }}</Link
                                >
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="border-b border-gray-800 md:border-0 lg:col-span-2">
                    <button
                        @click="toggle('support')"
                        class="flex w-full items-center justify-between py-4 text-left md:cursor-default md:py-0"
                    >
                        <h3
                            class="text-sm font-semibold uppercase tracking-wider text-white"
                        >
                            Support
                        </h3>
                        <svg
                            class="h-4 w-4 text-gray-500 transition-transform md:hidden"
                            :class="{ 'rotate-180': openSection === 'support' }"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M19 9l-7 7-7-7"
                            />
                        </svg>
                    </button>
                    <div
                        v-show="isDesktop || openSection === 'support'"
                        class="pb-4 md:pb-0"
                    >
                        <ul class="space-y-2.5">
                            <li>
                                <a
                                    href="#"
                                    class="text-sm text-gray-400 transition hover:text-white"
                                    >Contact Us</a
                                >
                            </li>
                            <li>
                                <a
                                    href="#"
                                    class="text-sm text-gray-400 transition hover:text-white"
                                    >Shipping &amp; Returns</a
                                >
                            </li>
                            <li>
                                <a
                                    href="#"
                                    class="text-sm text-gray-400 transition hover:text-white"
                                    >FAQs</a
                                >
                            </li>
                            <li>
                                <a
                                    href="#"
                                    class="text-sm text-gray-400 transition hover:text-white"
                                    >Size Guide</a
                                >
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="pt-4 md:pt-0 lg:col-span-2">
                    <h3
                        class="mb-4 text-sm font-semibold uppercase tracking-wider text-white"
                    >
                        Get in Touch
                    </h3>
                    <ul class="space-y-3">
                        <li class="flex items-start gap-3">
                            <span
                                class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-gray-800"
                            >
                                <svg
                                    class="h-4 w-4 text-gray-400"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                                    />
                                </svg>
                            </span>
                            <span class="text-sm text-gray-400">{{
                                companyEmail || '—'
                            }}</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span
                                class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-gray-800"
                            >
                                <svg
                                    class="h-4 w-4 text-gray-400"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"
                                    />
                                </svg>
                            </span>
                            <span class="text-sm text-gray-400">{{
                                companyMobile || '—'
                            }}</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span
                                class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-gray-800"
                            >
                                <svg
                                    class="h-4 w-4 text-gray-400"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                                    />
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"
                                    />
                                </svg>
                            </span>
                            <span class="text-sm text-gray-400">{{
                                companyAddress || '—'
                            }}</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span
                                class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-gray-800"
                            >
                                <svg
                                    class="h-4 w-4 text-gray-400"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                                    />
                                </svg>
                            </span>
                            <span class="text-sm text-gray-400">{{
                                companyWorkingHours || '—'
                            }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="border-t border-gray-800 dark:border-gray-800">
            <div
                class="mx-auto flex max-w-7xl flex-col items-center justify-between gap-3 px-4 py-5 sm:flex-row md:px-6"
            >
                <p class="text-xs text-gray-500">
                    &copy; {{ year }} {{ companyName }}. All rights reserved.
                </p>
                <div class="flex items-center gap-4 text-xs text-gray-500">
                    <template v-for="(p, i) in pages" :key="p.id">
                        <Link
                            :href="route('pages.show', p.slug)"
                            class="transition hover:text-gray-300"
                            >{{ p.title }}</Link
                        >
                        <span v-if="i < pages.length - 1" class="text-gray-800"
                            >|</span
                        >
                    </template>
                </div>
            </div>
        </div>
    </footer>

    <nav
        class="fixed bottom-0 left-0 right-0 z-40 flex h-16 items-center justify-around border-t border-gray-200 bg-white shadow-[0_-2px_10px_rgba(0,0,0,0.08)] dark:border-gray-800 dark:bg-gray-900 dark:shadow-[0_-2px_10px_rgba(0,0,0,0.3)] md:hidden"
    >
        <Link
            :href="route('home')"
            class="relative flex flex-col items-center gap-0.5 text-gray-500 transition hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400"
        >
            <svg
                class="h-5 w-5"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"
                />
            </svg>
            <span class="text-[10px] font-medium">Home</span>
        </Link>
        <Link
            :href="route('categories.index')"
            class="flex flex-col items-center gap-0.5 text-gray-500 transition hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400"
        >
            <svg
                class="h-5 w-5"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"
                />
            </svg>
            <span class="text-[10px] font-medium">Categories</span>
        </Link>
        <Link
            :href="route('wishlist.index')"
            class="relative flex flex-col items-center gap-0.5 text-gray-500 transition hover:text-red-500 dark:text-gray-400 dark:hover:text-red-400"
            aria-label="Wishlist"
        >
            <svg
                class="h-5 w-5"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"
                />
            </svg>
            <span class="text-[10px] font-medium">Wishlist</span>
            <span
                v-if="wishlistCount"
                class="absolute right-[calc(50%-22px)] top-0 flex h-4 min-w-[16px] items-center justify-center rounded-full bg-red-500 px-1 text-[10px] font-bold leading-none text-white"
                >{{ wishlistCount }}</span
            >
        </Link>
        <Link
            v-if="auth?.user"
            :href="route('orders.index')"
            class="flex flex-col items-center gap-0.5 text-gray-500 transition hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400"
        >
            <svg
                class="h-5 w-5"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                />
            </svg>
            <span class="text-[10px] font-medium">Profile</span>
        </Link>
        <Link
            v-else
            :href="route('login')"
            class="flex flex-col items-center gap-0.5 text-gray-500 transition hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400"
        >
            <svg
                class="h-5 w-5"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                />
            </svg>
            <span class="text-[10px] font-medium">Account</span>
        </Link>
    </nav>

    <div class="h-16 md:hidden"></div>
</template>
