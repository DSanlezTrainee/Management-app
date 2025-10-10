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
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                Article Details
            </h2>
        </template>
        <div class="py-6 max-w-3xl mx-auto">
            <div v-if="errors.error" class="text-red-500 mb-4">
                {{ errors.error }}
            </div>
            <div class="bg-white shadow rounded p-6">
                <div class="mb-4">
                    <span class="font-semibold">Name:</span>
                    {{ props.article.name }}
                </div>
                <div class="mb-4">
                    <span class="font-semibold">Reference:</span>
                    {{ props.article.reference }}
                </div>
                <div class="mb-4">
                    <span class="font-semibold">Description:</span>
                    {{ props.article.description }}
                </div>
                <div class="mb-4">
                    <span class="font-semibold">Price:</span>
                    {{ props.article.price }}
                </div>
                <div class="mb-4">
                    <span class="font-semibold">VAT Rate:</span>
                    {{ props.vatRate?.name || "-" }} ({{
                        props.vatRate?.rate || "-"
                    }}%)
                </div>
                <div class="mb-4">
                    <span class="font-semibold">Status:</span>
                    {{ props.article.status }}
                </div>
            </div>
        </div>
    </AppLayout>
</template>
