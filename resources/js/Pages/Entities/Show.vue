<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { defineProps } from "vue";
defineProps({ entity: Object });
</script>
<template>
    <AppLayout title="Entity Details">
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                Entity Details
            </h2>
        </template>
        <div class="py-6">
            <div class="bg-white dark:bg-gray-900 rounded shadow p-6">
                <div><strong>NIF:</strong> {{ entity.nif }}</div>
                <div><strong>Name:</strong> {{ entity.name }}</div>
                <div><strong>Phone:</strong> {{ entity.phone }}</div>
                <div><strong>Mobile:</strong> {{ entity.mobile }}</div>
                <div><strong>Website:</strong> {{ entity.website }}</div>
                <div><strong>Email:</strong> {{ entity.email }}</div>
                <div><strong>Status:</strong> {{ entity.status }}</div>
            </div>
        </div>
    </AppLayout>
</template>
