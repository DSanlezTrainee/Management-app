<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { defineProps } from "vue";
defineProps({ entity: Object });
</script>
<template>
    <AppLayout title="Entity Details">
        <template #header>
            <h2
                class="text-3xl font-extrabold text-cyan-900 dark:text-cyan-100 tracking-tight mb-6"
            >
                Entity Details
            </h2>
        </template>
        <div class="py-6 max-w-3xl mx-auto">
            <div class="bg-white/80 dark:bg-slate-800/80 shadow rounded-xl p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4">
                    <div>
                        <span
                            class="block text-sm font-medium text-gray-500 dark:text-gray-400"
                            >Number</span
                        >
                        <span
                            class="text-lg font-semibold text-gray-900 dark:text-gray-100"
                            >{{ entity.number }}</span
                        >
                    </div>
                    <div>
                        <span
                            class="block text-sm font-medium text-gray-500 dark:text-gray-400"
                            >NIF</span
                        >
                        <span
                            class="text-lg font-semibold text-gray-900 dark:text-gray-100"
                            >{{ entity.nif }}</span
                        >
                    </div>
                    <div>
                        <span
                            class="block text-sm font-medium text-gray-500 dark:text-gray-400"
                            >Name</span
                        >
                        <span
                            class="text-lg font-semibold text-gray-900 dark:text-gray-100"
                            >{{ entity.name }}</span
                        >
                    </div>
                    <div>
                        <span
                            class="block text-sm font-medium text-gray-500 dark:text-gray-400"
                            >Address</span
                        >
                        <span
                            class="text-lg font-semibold text-gray-900 dark:text-gray-100"
                            >{{ entity.address }}</span
                        >
                    </div>
                    <div>
                        <span
                            class="block text-sm font-medium text-gray-500 dark:text-gray-400"
                            >Postal Code</span
                        >
                        <span
                            class="text-lg font-semibold text-gray-900 dark:text-gray-100"
                            >{{ entity.postal_code }}</span
                        >
                    </div>
                    <div>
                        <span
                            class="block text-sm font-medium text-gray-500 dark:text-gray-400"
                            >City</span
                        >
                        <span
                            class="text-lg font-semibold text-gray-900 dark:text-gray-100"
                            >{{ entity.city }}</span
                        >
                    </div>
                    <div>
                        <span
                            class="block text-sm font-medium text-gray-500 dark:text-gray-400"
                            >Country</span
                        >
                        <span
                            class="text-lg font-semibold text-gray-900 dark:text-gray-100"
                            >{{ entity.country.name }}</span
                        >
                    </div>
                    <div>
                        <span
                            class="block text-sm font-medium text-gray-500 dark:text-gray-400"
                            >Phone</span
                        >
                        <span
                            class="text-lg font-semibold text-gray-900 dark:text-gray-100"
                            >{{ entity.phone }}</span
                        >
                    </div>
                    <div>
                        <span
                            class="block text-sm font-medium text-gray-500 dark:text-gray-400"
                            >Mobile</span
                        >
                        <span
                            class="text-lg font-semibold text-gray-900 dark:text-gray-100"
                            >{{ entity.mobile }}</span
                        >
                    </div>
                    <div>
                        <span
                            class="block text-sm font-medium text-gray-500 dark:text-gray-400"
                            >Website</span
                        >
                        <span
                            class="text-lg font-semibold text-gray-900 dark:text-gray-100"
                            >{{ entity.website }}</span
                        >
                    </div>
                    <div>
                        <span
                            class="block text-sm font-medium text-gray-500 dark:text-gray-400"
                            >Email</span
                        >
                        <span
                            class="text-lg font-semibold text-gray-900 dark:text-gray-100"
                            >{{ entity.email }}</span
                        >
                    </div>
                    <div>
                        <span
                            class="block text-sm font-medium text-gray-500 dark:text-gray-400"
                            >RGPD Consent</span
                        >
                        <span
                            class="text-lg font-semibold text-gray-900 dark:text-gray-100"
                            >{{ entity.rgpd_consent ? "Yes" : "No" }}</span
                        >
                    </div>
                    <div class="md:col-span-2">
                        <span
                            class="block text-sm font-medium text-gray-500 dark:text-gray-400"
                            >Notes</span
                        >
                        <span class="text-gray-900 dark:text-gray-100">{{
                            entity.notes
                        }}</span>
                    </div>
                    <div>
                        <span
                            class="block text-sm font-medium text-gray-500 dark:text-gray-400"
                            >Status</span
                        >
                        <span
                            class="text-lg font-semibold text-gray-900 dark:text-gray-100"
                            >{{ entity.status }}</span
                        >
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
