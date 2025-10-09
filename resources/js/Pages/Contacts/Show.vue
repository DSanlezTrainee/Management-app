<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";

const props = defineProps({
    contact: Object,
});
</script>

<template>
    <AppLayout title="Contact Details">
        <div class="max-w-2xl mx-auto bg-white rounded shadow p-6">
            <h2 class="text-xl font-bold mb-4">{{ contact.first_name }} {{ contact.last_name }}</h2>
            <p><strong>Entity:</strong> {{ contact.entity?.name }}</p>
            <p><strong>Function:</strong> {{ contact.contact_function?.name }}</p>
            <p><strong>Email:</strong> {{ contact.email }}</p>
            <p><strong>Phone:</strong> {{ contact.phone }}</p>
            <p><strong>Mobile:</strong> {{ contact.mobile }}</p>
            <p><strong>Status:</strong> {{ contact.status }}</p>
            <p><strong>RGPD Consent:</strong> {{ contact.rgpd_consent ? 'Yes' : 'No' }}</p>
            <p><strong>Notes:</strong> {{ contact.notes }}</p>
        </div>
    </AppLayout>
</template>