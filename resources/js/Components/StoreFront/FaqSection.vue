<script setup>
import { ref } from 'vue';

const { faqs } = defineProps({
    faqs: { type: Array, default: () => [] },
});

const openIndex = ref(null);

function toggle(index) {
    openIndex.value = openIndex.value === index ? null : index;
}
</script>

<template>
    <section v-if="faqs.length" class="mb-16">
        <div class="text-center mb-10">
            <span class="inline-block text-xs font-bold uppercase tracking-widest text-[#D9531E] dark:text-orange-400 mb-2">FAQ</span>
            
        </div>

        <div class="mx-auto max-w-3xl space-y-3">
            <div
                v-for="(faq, i) in faqs"
                :key="i"
                class="group rounded-2xl border transition-all duration-300"
                :class="openIndex === i
                    ? 'border-[#D9531E]/30 bg-white shadow-lg shadow-orange-100/50 dark:border-orange-500/30 dark:bg-gray-800 dark:shadow-orange-900/20'
                    : 'border-gray-200 bg-white hover:border-gray-300 hover:shadow-md dark:border-gray-700 dark:bg-gray-800 dark:hover:border-gray-600'"
            >
                <button
                    @click="toggle(i)"
                    class="flex w-full items-center gap-4 px-5 py-4 text-left md:px-6 md:py-5"
                >
                    <span
                        class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full text-sm font-bold transition-all duration-300 md:h-9 md:w-9"
                        :class="openIndex === i
                            ? 'bg-[#D9531E] text-white shadow-md shadow-orange-200/70 dark:shadow-orange-900/30'
                            : 'bg-orange-50 text-[#D9531E] dark:bg-orange-500/10 dark:text-orange-400'"
                    >{{ i + 1 }}</span>

                    <span
                        class="flex-1 text-sm font-semibold leading-snug transition-colors md:text-base"
                        :class="openIndex === i
                            ? 'text-[#D9531E] dark:text-orange-400'
                            : 'text-gray-800 dark:text-gray-100'"
                    >{{ faq.question }}</span>

                    <span
                        class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full transition-all duration-300 md:h-8 md:w-8"
                        :class="openIndex === i
                            ? 'rotate-180 bg-[#D9531E] text-white'
                            : 'bg-gray-100 text-gray-400 group-hover:bg-orange-100 group-hover:text-[#D9531E] dark:bg-gray-700 dark:text-gray-500 dark:group-hover:bg-orange-500/10 dark:group-hover:text-orange-400'"
                    >
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </span>
                </button>

                <div
                    class="overflow-hidden transition-all duration-300 ease-in-out"
                    :class="openIndex === i ? 'max-h-96 opacity-100' : 'max-h-0 opacity-0'"
                >
                    <div class="border-t border-gray-100 dark:border-gray-700 mx-5 md:mx-6"></div>
                    <p class="px-5 pt-4 pb-5 text-sm leading-relaxed text-gray-600 dark:text-gray-400 md:px-6 md:pb-6">
                        {{ faq.answer }}
                    </p>
                </div>
            </div>
        </div>
    </section>
</template>
