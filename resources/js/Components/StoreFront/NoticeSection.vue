<script setup>
defineProps({
    notices: { type: Array, default: () => [] },
});
</script>

<template>
    <section v-if="notices.length > 0" class="mb-16">
        <div class="text-center mb-10">
            <span class="inline-block text-xs font-bold uppercase tracking-widest text-[#D9531E] dark:text-orange-400 mb-2">Notice</span>
            
        </div>

        <div class="mx-auto max-w-3xl space-y-4">
            <div
                v-for="notice in notices"
                :key="notice.id"
                class="group rounded-2xl border border-gray-200 bg-white p-4 transition-all duration-300 hover:border-[#D9531E]/30 hover:shadow-lg hover:shadow-orange-100/50 dark:border-gray-700 dark:bg-gray-800 dark:hover:border-orange-500/30 dark:hover:shadow-orange-900/20 md:p-5"
            >
                <div class="flex gap-4">
                    <div v-if="notice.image" class="shrink-0">
                        <div class="h-20 w-20 overflow-hidden rounded-xl border border-gray-100 bg-gradient-to-br from-orange-50 to-amber-50 dark:border-gray-700 dark:from-orange-500/10 dark:to-amber-500/10 md:h-24 md:w-24">
                            <img
                                :src="`/${notice.image}`"
                                :alt="notice.title"
                                class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110"
                            />
                        </div>
                    </div>
                    <div class="min-w-0 flex-1">
                        <div class="flex items-start gap-3">
                            <span class="mt-1 flex h-2 w-2 shrink-0 rounded-full bg-[#D9531E] shadow-sm shadow-orange-200 dark:shadow-orange-900"></span>
                            <div class="min-w-0">
                                <h3 class="text-sm font-bold leading-snug text-gray-800 transition-colors group-hover:text-[#D9531E] dark:text-gray-100 dark:group-hover:text-orange-400 md:text-base">
                                    {{ notice.title }}
                                </h3>
                                <p class="mt-2 text-xs leading-relaxed text-gray-500 dark:text-gray-400 md:text-sm">
                                    {{ notice.content }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
