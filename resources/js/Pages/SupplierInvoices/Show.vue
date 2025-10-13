<template>
    <AppLayout title="Supplier Invoice Details">
        <template #header>
            <h2
                class="text-3xl font-extrabold text-cyan-900 dark:text-cyan-100 tracking-tight mb-6"
            >
                Supplier Invoice Details
            </h2>
        </template>
        <div class="py-6 max-w-3xl mx-auto">
            <div
                class="bg-white/80 dark:bg-slate-800/80 shadow rounded-xl p-8 mb-8"
            >
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                    <div>
                        <span
                            class="block text-sm font-medium text-gray-500 dark:text-gray-400"
                            >Number</span
                        >
                        <span
                            class="text-lg font-semibold text-gray-900 dark:text-gray-100"
                            >{{ invoice.number }}</span
                        >
                    </div>
                    <div>
                        <span
                            class="block text-sm font-medium text-gray-500 dark:text-gray-400"
                            >Date</span
                        >
                        <span
                            class="text-lg font-semibold text-gray-900 dark:text-gray-100"
                            >{{ invoice.invoice_date }}</span
                        >
                    </div>
                    <div>
                        <span
                            class="block text-sm font-medium text-gray-500 dark:text-gray-400"
                            >Supplier</span
                        >
                        <span
                            class="text-lg font-semibold text-gray-900 dark:text-gray-100"
                            >{{ invoice.supplier?.name }}</span
                        >
                    </div>
                    <div>
                        <span
                            class="block text-sm font-medium text-gray-500 dark:text-gray-400"
                            >Total</span
                        >
                        <span
                            class="text-lg font-semibold text-gray-900 dark:text-gray-100"
                            >{{ invoice.total }}</span
                        >
                    </div>
                    <div>
                        <span
                            class="block text-sm font-medium text-gray-500 dark:text-gray-400"
                            >Status</span
                        >
                        <span
                            class="text-lg font-semibold text-gray-900 dark:text-gray-100"
                            >{{ invoice.status }}</span
                        >
                    </div>
                    <div v-if="invoice.document">
                        <span
                            class="block text-sm font-medium text-gray-500 dark:text-gray-400"
                            >Document</span
                        >
                        <a
                            :href="`/storage/${invoice.document}`"
                            target="_blank"
                            class="inline-block mt-1 px-4 py-2 rounded-lg bg-cyan-700 text-white font-semibold shadow hover:bg-cyan-800 transition-all duration-150 focus:outline-none focus-visible:ring-2 focus-visible:ring-cyan-400"
                        >
                            View Document
                        </a>
                    </div>
                    <div v-if="invoice.payment_receipt">
                        <span
                            class="block text-sm font-medium text-gray-500 dark:text-gray-400"
                            >Payment Proof</span
                        >
                        <a
                            :href="`/storage/${invoice.payment_receipt}`"
                            target="_blank"
                            class="inline-block mt-1 px-4 py-2 rounded-lg bg-cyan-700 text-white font-semibold shadow hover:bg-cyan-800 transition-all duration-150 focus:outline-none focus-visible:ring-2 focus-visible:ring-cyan-400"
                        >
                            View Proof
                        </a>
                    </div>
                </div>
                <div class="mt-10 flex flex-col sm:flex-row gap-2 justify-end">
                    <inertia-link
                        :href="route('supplier-invoices.edit', invoice.id)"
                        class="inline-block px-4 py-2 rounded-lg bg-yellow-500 text-white font-semibold shadow hover:bg-yellow-600 transition-all duration-150 focus:outline-none focus-visible:ring-2 focus-visible:ring-yellow-300"
                    >
                        Edit
                    </inertia-link>
                    <inertia-link
                        :href="route('supplier-invoices.index')"
                        class="inline-block px-4 py-2 rounded-lg bg-gray-400 text-white font-semibold shadow hover:bg-gray-500 transition-all duration-150 focus:outline-none focus-visible:ring-2 focus-visible:ring-gray-300"
                    >
                        Back
                    </inertia-link>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
const props = defineProps({ invoice: Object });
const invoice = props.invoice;
</script>
