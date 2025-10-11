<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { usePage } from "@inertiajs/vue3";

const props = defineProps({
    proposal: Object,
});

const { errors } = usePage().props;

function formatQuantity(q) {
    const n = Number(q);
    return Number.isInteger(n)
        ? n
        : n.toLocaleString(undefined, { maximumFractionDigits: 2 });
}

function formatPrice(p) {
    const n = Number(p);
    if (Number.isInteger(n)) return n + "€";
    return (
        n.toLocaleString(undefined, {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2,
        }) + "€"
    );
}
</script>

<template>
    <AppLayout title="Proposal Details">
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                Proposal Details
            </h2>
        </template>
        <div class="py-6 max-w-3xl mx-auto">
            <div class="mb-6 flex justify-end">
                <a
                    :href="route('proposals.pdf', props.proposal.id)"
                    target="_blank"
                    class="px-4 py-2 bg-gray-700 text-white rounded hover:bg-gray-900"
                >
                    Download PDF
                </a>
            </div>
            <div v-if="errors.error" class="text-red-500 mb-4">
                {{ errors.error }}
            </div>
            <div class="bg-white shadow rounded p-6">
                <div class="mb-4">
                    <span class="font-semibold">Number:</span>
                    {{ props.proposal.number }}
                </div>
                <div class="mb-4">
                    <span class="font-semibold">Date:</span>
                    {{ props.proposal.date }}
                </div>
                <div class="mb-4">
                    <span class="font-semibold">Valid Until:</span>
                    {{ props.proposal.valid_until }}
                </div>
                <div class="mb-4">
                    <span class="font-semibold">Client:</span>
                    {{ props.proposal.client?.name || "-" }}
                </div>
                <div class="mb-4">
                    <span class="font-semibold">Status:</span>
                    {{ props.proposal.status }}
                </div>
                <div class="mb-4">
                    <span class="font-semibold">Total:</span>
                    {{ props.proposal.total }}
                </div>
                <div class="mb-4">
                    <span class="font-semibold">Lines:</span>
                    <table class="w-full mt-2 border">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="p-2 border">Article</th>
                                <th class="p-2 border">Qty</th>
                                <th class="p-2 border">Price</th>
                                <th class="p-2 border">Supplier</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="line in props.proposal.lines"
                                :key="line.id"
                            >
                                <td class="p-2 border">
                                    {{ line.article?.name || "-" }}
                                </td>
                                <td class="p-2 border">
                                    {{ formatQuantity(line.quantity) }}
                                </td>
                                <td class="p-2 border">
                                    {{ formatPrice(line.price) }}
                                </td>
                                <td class="p-2 border">
                                    {{ line.supplier?.name || "-" }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
