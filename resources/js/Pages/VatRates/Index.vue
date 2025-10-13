<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link, router } from "@inertiajs/vue3";
import DataTable from "@/Components/ui/table/DataTable.vue";

defineProps({
    vatRates: Object,
});

function deleteVatRate(id) {
    if (confirm("Are you sure you want to delete this VAT rate?")) {
        router.delete(route("vat-rates.destroy", id));
    }
}
</script>

<template>
    <AppLayout title="VAT Rates">
        <template #header>
            <h2
                class="text-3xl font-extrabold text-cyan-900 dark:text-cyan-100 tracking-tight mb-2 flex items-center gap-2"
            >
                <svg
                    class="w-8 h-8 text-cyan-600"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <line x1="6" y1="18" x2="18" y2="6" />
                    <circle cx="7.5" cy="7.5" r="2" />
                    <circle cx="16.5" cy="16.5" r="2" />
                </svg>
                VAT Rates
            </h2>
        </template>
        <div class="mb-10 flex justify-end">
            <Link
                :href="route('vat-rates.create')"
                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg bg-cyan-700 text-white font-semibold shadow hover:bg-cyan-800 transition-all duration-150 focus:outline-none focus-visible:ring-2 focus-visible:ring-cyan-400"
            >
                <svg
                    class="w-5 h-5"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 4v16m8-8H4"
                    />
                </svg>
                New VAT Rate
            </Link>
        </div>
        <div
            class="overflow-x-auto rounded-xl shadow bg-transparent dark:bg-transparent"
        >
            <DataTable
                :columns="[
                    { key: 'name', label: 'Name' },
                    { key: 'rate', label: 'Rate (%)' },
                    { key: 'active', label: 'Active' },
                    { key: 'actions', label: 'Actions' },
                ]"
                :data="vatRates.data ?? vatRates"
                table-class="min-w-full divide-y divide-gray-200 dark:divide-slate-700"
                head-class="bg-cyan-50 dark:bg-slate-800 text-cyan-900 dark:text-cyan-100 text-sm font-bold"
                row-class="hover:bg-cyan-50 dark:hover:bg-slate-800 transition"
            >
                <template #cell-active="{ row }">
                    <span
                        :class="row.active ? 'text-green-600' : 'text-gray-400'"
                    >
                        {{ row.active ? "Yes" : "No" }}
                    </span>
                </template>
                <template #cell-rate="{ row }">
                    {{ parseFloat(row.rate) }}%
                </template>
                <template #cell-actions="{ row }">
                    <div
                        class="flex flex-col sm:flex-row items-start sm:items-center gap-1 sm:gap-2"
                    >
                        <Link
                            :href="route('vat-rates.show', row.id)"
                            class="inline-flex items-center gap-1 text-cyan-700 dark:text-cyan-300 font-semibold hover:underline hover:text-cyan-900 dark:hover:text-cyan-100 transition"
                        >
                            <svg
                                class="w-4 h-4"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M15 12H9m12 0A9 9 0 11 3 12a9 9 0 0118 0z"
                                />
                            </svg>
                            View
                        </Link>
                        <Link
                            :href="route('vat-rates.edit', row.id)"
                            class="inline-flex items-center gap-1 text-yellow-600 dark:text-yellow-400 font-semibold hover:underline hover:text-yellow-700 dark:hover:text-yellow-200 transition"
                        >
                            <svg
                                class="w-4 h-4"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M15.232 5.232l3.536 3.536M9 11l6 6M3 21h6l11.293-11.293a1 1 0 000-1.414l-3.586-3.586a1 1 0 00-1.414 0L3 15v6z"
                                />
                            </svg>
                            Edit
                        </Link>
                        <button
                            @click.prevent="deleteVatRate(row.id)"
                            class="inline-flex items-center gap-1 text-red-600 dark:text-red-400 font-semibold hover:underline hover:text-red-800 dark:hover:text-red-200 transition"
                        >
                            <svg
                                class="w-4 h-4"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M6 18L18 6M6 6l12 12"
                                />
                            </svg>
                            Delete
                        </button>
                    </div>
                </template>
            </DataTable>
        </div>
    </AppLayout>
</template>
