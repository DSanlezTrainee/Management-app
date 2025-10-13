<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";

const props = defineProps({ order: Object });
</script>
<template>
    <AppLayout title="Detalhe da Encomenda de Fornecedor">
        <template #header>
            <h2
                class="text-3xl font-extrabold text-cyan-900 dark:text-cyan-100 tracking-tight mb-6"
            >
                Supplier Order Details
            </h2>
        </template>
        <div class="py-6 max-w-4xl mx-auto">
            <div
                class="bg-white/80 dark:bg-slate-800/80 shadow rounded-xl p-8 mb-8"
            >
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4">
                    <div>
                        <span
                            class="block text-sm font-medium text-gray-500 dark:text-gray-400"
                            >Number</span
                        >
                        <span
                            class="text-lg font-semibold text-gray-900 dark:text-gray-100"
                            >{{ order.number }}</span
                        >
                    </div>
                    <div>
                        <span
                            class="block text-sm font-medium text-gray-500 dark:text-gray-400"
                            >Date</span
                        >
                        <span
                            class="text-lg font-semibold text-gray-900 dark:text-gray-100"
                            >{{ order.date }}</span
                        >
                    </div>
                    <div>
                        <span
                            class="block text-sm font-medium text-gray-500 dark:text-gray-400"
                            >Supplier</span
                        >
                        <span
                            class="text-lg font-semibold text-gray-900 dark:text-gray-100"
                            >{{ order.supplier?.name }}</span
                        >
                    </div>
                    <div>
                        <span
                            class="block text-sm font-medium text-gray-500 dark:text-gray-400"
                            >Validity</span
                        >
                        <span
                            class="text-lg font-semibold text-gray-900 dark:text-gray-100"
                            >{{ order.valid_until }}</span
                        >
                    </div>
                    <div>
                        <span
                            class="block text-sm font-medium text-gray-500 dark:text-gray-400"
                            >Total Amount</span
                        >
                        <span
                            class="text-lg font-semibold text-gray-900 dark:text-gray-100"
                            >{{ order.total }}</span
                        >
                    </div>
                    <div>
                        <span
                            class="block text-sm font-medium text-gray-500 dark:text-gray-400"
                            >Status</span
                        >
                        <span
                            class="text-lg font-semibold text-gray-900 dark:text-gray-100"
                            >{{ order.status }}</span
                        >
                    </div>
                </div>
                <!-- Se houver rota para PDF, descomente abaixo -->
                <!--
                <a
                    :href="route('supplier-orders.pdf', order.id)"
                    target="_blank"
                    class="inline-block mt-6 px-4 py-2 rounded-lg bg-cyan-700 text-white font-semibold shadow hover:bg-cyan-800 transition-all duration-150 focus:outline-none focus-visible:ring-2 focus-visible:ring-cyan-400"
                >
                    Download PDF
                </a>
                -->
            </div>
            <div class="bg-white/80 dark:bg-slate-800/80 shadow rounded-xl p-8">
                <h3
                    class="font-semibold mb-4 text-lg text-cyan-900 dark:text-cyan-100"
                >
                    Order Lines
                </h3>
                <div class="overflow-x-auto">
                    <table
                        class="min-w-full divide-y divide-gray-200 dark:divide-slate-700"
                    >
                        <thead
                            class="bg-cyan-50 dark:bg-slate-800 text-cyan-900 dark:text-cyan-100 text-sm font-bold"
                        >
                            <tr>
                                <th class="px-4 py-2 text-left">Article</th>
                                <th class="px-4 py-2 text-left">Quantity</th>
                                <th class="px-4 py-2 text-left">Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="line in order.lines"
                                :key="line.id"
                                class="hover:bg-cyan-50 dark:hover:bg-slate-800 transition"
                            >
                                <td class="px-4 py-2">
                                    {{ line.article?.name }}
                                </td>
                                <td class="px-4 py-2">{{ line.quantity }}</td>
                                <td class="px-4 py-2">{{ line.price }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
