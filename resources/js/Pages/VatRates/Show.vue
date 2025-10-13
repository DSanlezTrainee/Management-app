<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";

const props = defineProps({
    vatRate: Object,
});
</script>

<template>
    <AppLayout title="VAT Rate Details">
        <div class="py-6 max-w-lg mx-auto">
            <div class="bg-white/80 dark:bg-slate-800/80 shadow rounded-xl p-8">
                <h2
                    class="text-3xl font-extrabold text-cyan-900 dark:text-cyan-100 tracking-tight mb-6"
                >
                    {{ vatRate.name }}
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4">
                    <div>
                        <span
                            class="block text-sm font-medium text-gray-500 dark:text-gray-400"
                            >Rate</span
                        >
                        <span
                            class="text-lg font-semibold text-gray-900 dark:text-gray-100"
                            >{{ vatRate.rate }} %</span
                        >
                    </div>
                    <div>
                        <span
                            class="block text-sm font-medium text-gray-500 dark:text-gray-400"
                            >Active</span
                        >
                        <span
                            class="text-lg font-semibold text-gray-900 dark:text-gray-100"
                            >{{ vatRate.active ? "Yes" : "No" }}</span
                        >
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
