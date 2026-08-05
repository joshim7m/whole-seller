<script setup>
import { Head, Link } from '@inertiajs/vue3';
import FrontEndMaster from '@/Layouts/Frontend/FrontEndMaster.vue';

const { page } = defineProps({
    page: { type: Object, required: true },
});
</script>

<template>
    <Head :title="page.title" />

    <FrontEndMaster>
        <div class="relative flex min-h-full flex-col overflow-hidden">
            <div
                class="pointer-events-none absolute -left-24 -top-24 h-64 w-64 rounded-full bg-orange-200/40 blur-3xl dark:bg-orange-500/10"
                aria-hidden="true"
            ></div>
            <div
                class="pointer-events-none absolute -right-24 top-1/3 h-72 w-72 rounded-full bg-indigo-200/40 blur-3xl dark:bg-indigo-500/10"
                aria-hidden="true"
            ></div>

            <div
                class="relative z-10 mx-auto flex w-full max-w-3xl flex-1 flex-col px-4 py-8 sm:px-6 md:py-12"
            >
                <Link
                    :href="route('home')"
                    class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-500 transition hover:text-[#D9531E] dark:text-gray-400 dark:hover:text-orange-400"
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
                            d="M15 19l-7-7 7-7"
                        />
                    </svg>
                    Back to Home
                </Link>

                <header class="mb-6 mt-4 md:mb-8 md:mt-6">
                    <p
                        class="text-[11px] font-semibold uppercase tracking-[0.2em] text-[#D9531E] dark:text-orange-400"
                    >
                        Information
                    </p>
                    <h1
                        class="mt-2 text-2xl font-bold text-gray-900 dark:text-white sm:text-3xl md:text-4xl"
                    >
                        {{ page.title }}
                    </h1>
                    <div
                        class="mt-3 h-1 w-16 rounded-full bg-gradient-to-r from-[#D9531E] to-amber-400"
                    ></div>
                </header>

                <div
                    class="flex-1 rounded-xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-800 dark:bg-gray-900 sm:p-6 md:rounded-2xl md:p-8"
                >
                    <div
                        class="rich-text-content leading-relaxed text-gray-700 dark:text-gray-300"
                        v-html="page.content"
                    ></div>
                </div>
            </div>
        </div>
    </FrontEndMaster>
</template>
