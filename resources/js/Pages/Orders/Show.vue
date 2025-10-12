<template>
    <AppLayout title="Detalhe da Encomenda">
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                Order Details
            </h2>
        </template>
        <div class="py-6 max-w-4xl mx-auto">
            <div class="mb-4">
                <strong>Number:</strong> {{ order.number }}<br />
                <strong>Date:</strong> {{ order.date }}<br />
                <strong>Client:</strong> {{ order.client?.name }}<br />
                <strong>Valid Until:</strong> {{ order.valid_until }}<br />
                <strong>Total Amount:</strong> {{ order.total }}<br />
                <strong>Status:</strong> {{ order.status }}<br />
                <a
                    :href="route('orders.pdf', order.id)"
                    target="_blank"
                    class="inline-block mt-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition"
                >
                    Download PDF
                </a>
            </div>
            <h3 class="font-semibold mb-2">Order Lines</h3>
            <table class="min-w-full bg-white border">
                <thead>
                    <tr>
                        <th>Article</th>
                        <th>Supplier</th>
                        <th>Quantity</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="line in order.lines" :key="line.id">
                        <td>{{ line.article?.name }}</td>
                        <td>{{ line.supplier?.name }}</td>
                        <td>{{ line.quantity }}</td>
                        <td>{{ line.price }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";

const props = defineProps({
    order: Object,
});
</script>
