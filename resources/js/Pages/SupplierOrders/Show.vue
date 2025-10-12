<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";

const props = defineProps({ order: Object });

</script>
<template>
    <AppLayout title="Detalhe da Encomenda de Fornecedor">
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                Supplier Order Details
            </h2>
        </template>
        <div class="py-6 max-w-4xl mx-auto">
            <div class="mb-4">
                <strong>Number:</strong> {{ order.number }}<br />
                <strong>Date:</strong> {{ order.date }}<br />
                <strong>Supplier:</strong> {{ order.supplier?.name }}<br />
                <strong>Validity:</strong> {{ order.valid_until }}<br />
                <strong>Total Amount:</strong> {{ order.total }}<br />
                <strong>Status:</strong> {{ order.status }}<br />
            </div>
            <h3 class="font-semibold mb-2">Order Lines</h3>
            <table class="min-w-full bg-white border">
                <thead>
                    <tr>
                        <th>Article</th>
                        <th>Quantity</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="line in order.lines" :key="line.id">
                        <td>{{ line.article?.name }}</td>
                        <td>{{ line.quantity }}</td>
                        <td>{{ line.price }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </AppLayout>
</template>
