<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";

const props = defineProps({
    vatRate: Object,
});
</script>

<template>
    <AppLayout title="VAT Rate Details">
        <div class="max-w-lg mx-auto bg-white rounded shadow p-6">
            <h2 class="text-xl font-bold mb-4">{{ vatRate.name }}</h2>
            <p><strong>Rate:</strong> {{ vatRate.rate }} %</p>
            <p><strong>Active:</strong> {{ vatRate.active ? 'Yes' : 'No' }}</p>
        </div>
    </AppLayout>
</template>