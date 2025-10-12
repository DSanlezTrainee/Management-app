<template>
    <div>
        <h1 class="text-2xl font-bold mb-4">Detalhe da Fatura de Fornecedor</h1>
        <div v-if="invoice">
            <p><strong>Número:</strong> {{ invoice.number }}</p>
            <p><strong>Data:</strong> {{ invoice.invoice_date }}</p>
            <p><strong>Fornecedor:</strong> {{ invoice.supplier?.name }}</p>
            <p><strong>Total:</strong> {{ invoice.total }}</p>
            <p><strong>Status:</strong> {{ invoice.status }}</p>
            <div v-if="invoice.document">
                <a
                    :href="`/storage/${invoice.document}`"
                    target="_blank"
                    class="text-blue-600"
                    >Ver Documento</a
                >
            </div>
            <div v-if="invoice.payment_receipt">
                <a
                    :href="`/storage/${invoice.payment_receipt}`"
                    target="_blank"
                    class="text-blue-600"
                    >Ver Comprovativo</a
                >
            </div>
        </div>
        <inertia-link
            :href="route('supplier-invoices.edit', invoice.id)"
            class="btn btn-primary mt-4"
            >Editar</inertia-link
        >
        <inertia-link
            :href="route('supplier-invoices.index')"
            class="btn btn-secondary mt-4 ml-2"
            >Voltar</inertia-link
        >
    </div>
</template>

<script setup>
import { defineProps } from "vue";
const props = defineProps({ invoice: Object });
</script>
