<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import SearchBox from '@/Components/StoreFront/SearchBox.vue';
import { useCart } from '@/composables/useCart';
import { useWishlist } from '@/composables/useWishlist';

defineEmits(['open-search', 'open-cart', 'open-mobile']);

const { count } = useCart();

const wishlist = useWishlist();
wishlist.load();
const wishlistCount = computed(() => wishlist.ids.value.length);

const page = usePage();
const settings = page.props.settings || {};
const auth = page.props.auth;

const userMenuOpen = ref(false);
const userMenuEl = ref(null);
const mobileSearchOpen = ref(false);
const isDark = ref(localStorage.getItem('darkMode') === 'true');

function toggleDark() {
    isDark.value = !isDark.value;
    localStorage.setItem('darkMode', isDark.value);
    document.documentElement.classList.toggle('dark', isDark.value);
}

onMounted(() => {
    if (isDark.value) {
        document.documentElement.classList.add('dark');
    }
});

function toggleUserMenu() {
    userMenuOpen.value = !userMenuOpen.value;
}

function onClickOutside(e) {
    if (userMenuEl.value && !userMenuEl.value.contains(e.target)) {
        userMenuOpen.value = false;
    }
}

onMounted(() => document.addEventListener('click', onClickOutside));
onUnmounted(() => document.removeEventListener('click', onClickOutside));
</script>

<template>
    <header
        class="relative sticky top-0 z-40 bg-gradient-to-br from-orange-50 via-rose-50 to-indigo-100 dark:bg-gray-900 dark:bg-none"
    >
        <div
            class="absolute inset-x-0 bottom-0 h-[3px] bg-gradient-to-r from-[#D9531E] via-amber-400 to-emerald-400 opacity-50"
        ></div>
        <div class="mx-auto max-w-7xl px-4 md:px-6">
            <div
                class="flex h-14 items-center justify-between gap-3 md:h-16 md:gap-4"
            >
                <div class="flex shrink-0 items-center gap-1 md:gap-2">
                    <button
                        @click="$emit('open-mobile')"
                        class="-ml-1.5 p-1.5 text-gray-700 transition hover:text-[#D9531E] dark:text-gray-300 dark:hover:text-orange-400 md:-ml-2"
                        aria-label="Open menu"
                    >
                        <svg
                            class="h-5 w-5 md:h-6 md:w-6"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"
                            />
                        </svg>
                    </button>
                    <Link :href="route('home')" class="shrink-0">
                        <img
                            v-if="settings.company_logo"
                            :src="`/${settings.company_logo}`"
                            :alt="settings.company_name || 'Store'"
                            class="h-8 w-auto md:h-10"
                        />
                        <span
                            v-else
                            class="text-xl font-bold tracking-tight text-gray-900 dark:text-white md:text-2xl"
                            >{{ settings.company_name || 'Store' }}</span
                        >
                    </Link>
                </div>

                <SearchBox class="hidden min-w-0 max-w-xl flex-1 sm:block" />

                <div class="flex shrink-0 items-center gap-1.5 md:gap-2">
                    <button
                        @click="mobileSearchOpen = !mobileSearchOpen"
                        class="p-1.5 text-gray-600 transition hover:text-[#D9531E] dark:text-gray-400 dark:hover:text-orange-400 sm:hidden"
                        aria-label="Search"
                    >
                        <svg
                            v-if="mobileSearchOpen"
                            class="h-5 w-5"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"
                            />
                        </svg>
                        <svg
                            v-else
                            class="h-5 w-5"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                            />
                        </svg>
                    </button>
                    <button
                        @click="toggleDark"
                        class="p-1.5 text-gray-600 transition hover:text-[#D9531E] dark:text-gray-400 dark:hover:text-orange-400"
                        aria-label="Toggle dark mode"
                    >
                        <svg
                            v-if="isDark"
                            class="h-5 w-5"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"
                            />
                        </svg>
                        <svg
                            v-else
                            class="h-5 w-5"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"
                            />
                        </svg>
                    </button>
                    <button
                        @click="$emit('open-cart')"
                        class="relative hidden p-1.5 text-gray-600 transition hover:text-[#D9531E] dark:text-gray-400 dark:hover:text-orange-400 sm:block"
                        aria-label="Cart"
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
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"
                            />
                        </svg>
                        <span
                            v-if="count"
                            class="absolute -right-0.5 -top-0.5 flex h-[18px] min-w-[18px] items-center justify-center rounded-full bg-blue-600 px-1 text-[10px] font-bold leading-none text-white"
                            >{{ count }}</span
                        >
                    </button>
                    <template v-if="auth?.user">
                        <div
                            class="hidden h-5 w-px bg-gray-200 dark:bg-gray-700 sm:block"
                        ></div>
                        <div ref="userMenuEl" class="relative">
                            <button
                                @click="toggleUserMenu"
                                class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-100 text-sm font-bold text-blue-600 transition hover:bg-blue-200 dark:bg-blue-900/40 dark:text-blue-400 dark:hover:bg-blue-900/60"
                                aria-label="User menu"
                            >
                                {{
                                    (auth.user.name || 'U')
                                        .charAt(0)
                                        .toUpperCase()
                                }}
                            </button>
                            <div
                                v-show="userMenuOpen"
                                class="absolute right-0 top-full z-50 mt-2 w-48 rounded-xl border border-gray-200 bg-white py-2 shadow-lg dark:border-gray-700 dark:bg-gray-900"
                            >
                                <Link
                                    :href="route('profile')"
                                    class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-gray-700 transition hover:bg-gray-50 dark:text-gray-300 dark:hover:bg-gray-800"
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
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                        />
                                    </svg>
                                    Profile
                                </Link>
                                <Link
                                    :href="route('orders.index')"
                                    class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-gray-700 transition hover:bg-gray-50 dark:text-gray-300 dark:hover:bg-gray-800"
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
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"
                                        />
                                    </svg>
                                    Orders
                                </Link>
                                <Link
                                    :href="route('wishlist.index')"
                                    class="flex items-center justify-between gap-2.5 px-4 py-2.5 text-sm text-gray-700 transition hover:bg-gray-50 dark:text-gray-300 dark:hover:bg-gray-800"
                                >
                                    <span class="flex items-center gap-2.5">
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
                                                d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"
                                            />
                                        </svg>
                                        Wishlist
                                    </span>
                                    <span
                                        v-if="wishlistCount"
                                        class="flex h-[18px] min-w-[18px] items-center justify-center rounded-full bg-red-500 px-1 text-[10px] font-bold leading-none text-white"
                                        >{{ wishlistCount }}</span
                                    >
                                </Link>
                                <hr
                                    class="my-1.5 border-gray-100 dark:border-gray-700"
                                />
                                <Link
                                    :href="route('logout')"
                                    method="post"
                                    as="button"
                                    class="flex w-full items-center gap-2.5 px-4 py-2.5 text-left text-sm text-red-600 transition hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-900/20"
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
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"
                                        />
                                    </svg>
                                    Logout
                                </Link>
                            </div>
                        </div>
                    </template>
                    <template v-else>
                        <div
                            class="hidden h-5 w-px bg-gray-200 dark:bg-gray-700 sm:block"
                        ></div>
                        <Link
                            :href="route('login')"
                            class="font-inter hidden text-sm font-medium text-gray-600 transition hover:text-[#D9531E] dark:text-gray-400 dark:hover:text-orange-400 sm:inline-block"
                            >Log in</Link
                        >
                    </template>
                </div>
            </div>

            <div v-show="mobileSearchOpen" class="pb-3 sm:hidden">
                <SearchBox class="w-full" :autofocus="mobileSearchOpen" />
            </div>
        </div>
    </header>
</template>
