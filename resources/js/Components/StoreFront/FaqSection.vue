<script setup>
import { ref } from 'vue'

const faqs = [
    {
        q: 'অর্ডার করার পর কত দিনের মধ্যে পণ্য ডেলিভারি পাব?',
        a: 'আমরা সাধারণত অর্ডার কনফার্মেশনের ৩-৭ কার্যদিবসের মধ্যে পণ্য ডেলিভারি করে থাকি। লোকেশন ভেদে সময় একটু কম-বেশি হতে পারে।'
    },
    {
        q: 'পণ্য রিটার্ন বা এক্সচেঞ্জের সুবিধা আছে কী?',
        a: 'হ্যাঁ, প্রোডাক্ট ডেলিভারির ৭ দিনের মধ্যে রিটার্ন বা এক্সচেঞ্জের সুবিধা রয়েছে। পণ্য অবশ্যই আন-ইউজড এবং অরিজিনাল প্যাকেজিংসহ থাকতে হবে।'
    },
    {
        q: 'ক্যাশ অন ডেলিভারি (COD) সুবিধা আছে কী?',
        a: 'হ্যাঁ, আমরা পুরো বাংলাদেশে ক্যাশ অন ডেলিভারি সুবিধা প্রদান করি। অর্ডার ডেলিভারির সময় পেমেন্ট করতে পারবেন।'
    },
    {
        q: 'পাইকারি মূল্যে পণ্য কিনতে কী করতে হবে?',
        a: 'পাইকারি মূল্যে পণ্য কিনতে আমাদের ওয়েবসাইটে রেজিস্ট্রেশন করে লগইন করতে হবে। রেজিস্ট্রেশনের পরই আপনি পাইকারি মূল্য দেখতে পাবেন।'
    },
    {
        q: 'একাধিক পণ্য অর্ডার করলে শিপিং চার্জ কেমন হবে?',
        a: 'শিপিং চার্জ নির্ভর করে পণ্যের ওজন এবং লোকেশনের উপর। নির্দিষ্ট পরিমাণ অর্ডারের boven ফ্রি শিপিং সুবিধা রয়েছে।'
    },
    {
        q: 'পণ্য সম্পর্কে আরও জানতে কোথায় যোগাযোগ করব?',
        a: 'আমাদের WhatsApp নম্বর এবং ফেসবুক পেজের মাধ্যমে সরাসরি যোগাযোগ করতে পারেন। পেজের নিচের দিকে WhatsApp বাটনে ক্লিক করলেই চ্যাট শুরু করতে পারবেন।'
    }
]

const openIndex = ref(null)

function toggle(index) {
    openIndex.value = openIndex.value === index ? null : index
}
</script>

<template>
    <section class="mb-16">
        <div class="flex flex-col items-center text-center mb-6">
            <div class="inline-flex items-center justify-center w-12 h-12 bg-blue-600 rounded-2xl mb-3 shadow-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                </svg>
            </div>
            <h2 class="text-xl md:text-2xl font-bold text-gray-800 dark:text-white font-bengali">সচরাচর জিজ্ঞাসা</h2>
            <p class="text-sm text-gray-400 dark:text-gray-500 mt-1 font-bengali">আপনার প্রশ্নের উত্তর খুঁজুন</p>
        </div>

        <div class="max-w-2xl mx-auto space-y-2 md:space-y-3 px-0">
            <div
                v-for="(faq, i) in faqs" :key="i"
                class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl overflow-hidden shadow-sm transition-all duration-200"
                :class="{ 'shadow-md dark:shadow-gray-900/40': openIndex === i }"
            >
                <button
                    @click="toggle(i)"
                    class="w-full flex items-center justify-between gap-3 px-4 md:px-5 py-3.5 md:py-4 text-left transition"
                    :class="openIndex === i ? 'bg-blue-50 dark:bg-blue-900/20' : 'hover:bg-gray-50 dark:hover:bg-gray-700/50'"
                >
                    <span class="text-sm md:text-base font-medium text-gray-800 dark:text-gray-100 font-bengali leading-relaxed pr-2">{{ faq.q }}</span>
                    <svg
                        class="w-4 h-4 md:w-5 md:h-5 shrink-0 text-gray-400 dark:text-gray-500 transition-transform duration-200"
                        :class="{ 'rotate-180': openIndex === i }"
                        fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div
                    class="overflow-hidden transition-all duration-300 ease-in-out"
                    :class="openIndex === i ? 'max-h-96 opacity-100' : 'max-h-0 opacity-0'"
                >
                    <p class="px-4 md:px-5 pb-3.5 md:pb-4 text-xs md:text-sm text-gray-600 dark:text-gray-400 font-bengali leading-relaxed">
                        {{ faq.a }}
                    </p>
                </div>
            </div>
        </div>
    </section>
</template>
