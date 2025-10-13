<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";

const props = defineProps({
    contact: Object,
});
</script>

<template>
    <AppLayout title="Contact Details">
        <div class="py-6 max-w-2xl mx-auto">
            <div class="bg-white/80 dark:bg-slate-800/80 shadow rounded-xl p-8">
                <h2
                    class="text-3xl font-extrabold text-cyan-900 dark:text-cyan-100 tracking-tight mb-6"
                >
                    {{ contact.first_name }} {{ contact.last_name }}
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4">
                    <div>
                        <span
                            class="block text-sm font-medium text-gray-500 dark:text-gray-400"
                            >Entity</span
                        >
                        <span
                            class="text-lg font-semibold text-gray-900 dark:text-gray-100"
                            >{{ contact.entity?.name }}</span
                        >
                    </div>
                    <div>
                        <span
                            class="block text-sm font-medium text-gray-500 dark:text-gray-400"
                            >Function</span
                        >
                        <span
                            class="text-lg font-semibold text-gray-900 dark:text-gray-100"
                            >{{ contact.contact_function?.name }}</span
                        >
                    </div>
                    <div>
                        <span
                            class="block text-sm font-medium text-gray-500 dark:text-gray-400"
                            >Email</span
                        >
                        <span
                            class="text-lg font-semibold text-gray-900 dark:text-gray-100"
                            >{{ contact.email }}</span
                        >
                    </div>
                    <div>
                        <span
                            class="block text-sm font-medium text-gray-500 dark:text-gray-400"
                            >Phone</span
                        >
                        <span
                            class="text-lg font-semibold text-gray-900 dark:text-gray-100"
                            >{{ contact.phone }}</span
                        >
                    </div>
                    <div>
                        <span
                            class="block text-sm font-medium text-gray-500 dark:text-gray-400"
                            >Mobile</span
                        >
                        <span
                            class="text-lg font-semibold text-gray-900 dark:text-gray-100"
                            >{{ contact.mobile }}</span
                        >
                    </div>
                    <div>
                        <span
                            class="block text-sm font-medium text-gray-500 dark:text-gray-400"
                            >Status</span
                        >
                        <span
                            class="text-lg font-semibold text-gray-900 dark:text-gray-100"
                            >{{ contact.status }}</span
                        >
                    </div>
                    <div>
                        <span
                            class="block text-sm font-medium text-gray-500 dark:text-gray-400"
                            >RGPD Consent</span
                        >
                        <span
                            class="text-lg font-semibold text-gray-900 dark:text-gray-100"
                            >{{ contact.rgpd_consent ? "Yes" : "No" }}</span
                        >
                    </div>
                    <div class="md:col-span-2">
                        <span
                            class="block text-sm font-medium text-gray-500 dark:text-gray-400"
                            >Notes</span
                        >
                        <span class="text-gray-900 dark:text-gray-100">{{
                            contact.notes
                        }}</span>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
