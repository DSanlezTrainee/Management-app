<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { usePage } from "@inertiajs/vue3";

const props = defineProps({
    article: Object,
    vatRate: Object,
});

const { errors } = usePage().props;
</script>

<template>
    <AppLayout title="Article Details">
        <template #header>
            <h2
                class="text-3xl font-extrabold text-cyan-900 dark:text-cyan-100 tracking-tight mb-6"
            >
                Article Details
            </h2>
        </template>
        <div class="py-6 max-w-3xl mx-auto">
            <div v-if="errors.error" class="text-red-500 mb-4">
                {{ errors.error }}
            </div>
            <div class="bg-white/80 dark:bg-slate-800/80 shadow rounded-xl p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4">
                    <div>
                        <span
                            class="block text-sm font-medium text-gray-500 dark:text-gray-400"
                            >Name</span
                        >
                        <span
                            class="text-lg font-semibold text-gray-900 dark:text-gray-100"
                            >{{ props.article.name }}</span
                        >
                    </div>
                    <div>
                        <span
                            class="block text-sm font-medium text-gray-500 dark:text-gray-400"
                            >Reference</span
                        >
                        <span
                            class="text-lg font-semibold text-gray-900 dark:text-gray-100"
                            >{{ props.article.reference }}</span
                        >
                    </div>
                    <div class="md:col-span-2">
                        <span
                            class="block text-sm font-medium text-gray-500 dark:text-gray-400"
                            >Description</span
                        >
                        <span class="text-gray-900 dark:text-gray-100">{{
                            props.article.description
                        }}</span>
                    </div>
                    <div>
                        <span
                            class="block text-sm font-medium text-gray-500 dark:text-gray-400"
                            >Price</span
                        >
                        <span
                            class="text-lg font-semibold text-gray-900 dark:text-gray-100"
                            >{{ props.article.price }}</span
                        >
                    </div>
                    <div>
                        <span
                            class="block text-sm font-medium text-gray-500 dark:text-gray-400"
                            >VAT Rate</span
                        >
                        <span
                            class="text-lg font-semibold text-gray-900 dark:text-gray-100"
                            >{{ props.vatRate?.name || "-" }} ({{
                                props.vatRate?.rate || "-"
                            }}%)</span
                        >
                    </div>
                    <div>
                        <span
                            class="block text-sm font-medium text-gray-500 dark:text-gray-400"
                            >Status</span
                        >
                        <span
                            class="text-lg font-semibold text-gray-900 dark:text-gray-100"
                            >{{ props.article.status }}</span
                        >
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
