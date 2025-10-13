<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link, usePage, router } from "@inertiajs/vue3";
import DataTable from "@/Components/ui/table/DataTable.vue";
import { ref, watch, onMounted } from "vue";

const props = defineProps({ invoices: Object });
const page = usePage();
const showFlash = ref(false);

function startFlashTimer() {
    showFlash.value = true;
    setTimeout(() => {
        showFlash.value = false;
    }, 2000);
}

onMounted(() => {
    if (
        page.props.flash &&
        (page.props.flash.success || page.props.flash.error)
    ) {
        startFlashTimer();
    }
});

watch(
    () => page.props.flash,
    (newFlash) => {
        if (newFlash && (newFlash.success || newFlash.error)) {
            startFlashTimer();
        }
    },
    { deep: true },
);

function destroyInvoice(id) {
    if (confirm("Are you sure you want to delete this invoice?")) {
        router.delete(route("supplier-invoices.destroy", id));
    }
}
</script>

<template>
    <AppLayout title="Suppliers Invoices">
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
                    <rect x="4" y="4" width="16" height="16" rx="3" />
                    <path d="M8 8h8M8 12h8M8 16h4" />
                </svg>
                Suppliers Invoices
            </h2>
            <div
                v-if="showFlash && page.props.flash && page.props.flash.success"
                class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded fixed top-24 right-4 z-50 shadow-lg"
                style="max-width: 300px"
            >
                <span class="font-medium">Success!</span>
                {{ page.props.flash.success }}
            </div>
            <div
                v-if="showFlash && page.props.flash && page.props.flash.error"
                class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded fixed top-24 right-4 z-50 shadow-lg"
                style="max-width: 300px"
            >
                <span class="font-medium">Error!</span>
                {{ page.props.flash.error }}
            </div>
        </template>
        <div class="py-6">
            <div class="mb-10 flex justify-end">
                <Link
                    :href="route('supplier-invoices.create')"
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
                    New Invoice
                </Link>
            </div>
            <div
                class="overflow-x-auto rounded-xl shadow bg-transparent dark:bg-transparent"
            >
                <DataTable
                    :columns="[
                        { key: 'invoice_date', label: 'Date' },
                        { key: 'number', label: 'Number' },
                        { key: 'supplier', label: 'Supplier' },
                        { key: 'total', label: 'Total' },
                        { key: 'status', label: 'Status' },
                        { key: 'actions', label: 'Actions' },
                    ]"
                    :data="invoices.data"
                    table-class="min-w-full divide-y divide-gray-200 dark:divide-slate-700"
                    head-class="bg-cyan-50 dark:bg-slate-800 text-cyan-900 dark:text-cyan-100 text-sm font-bold"
                    row-class="hover:bg-cyan-50 dark:hover:bg-slate-800 transition"
                >
                    <template #cell-supplier="{ row }">
                        {{ row.supplier?.name || "-" }}
                    </template>
                    <template #cell-total="{ row }">
                        {{
                            Number(row.total).toLocaleString(undefined, {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2,
                            }) + "€"
                        }}
                    </template>
                    <template #cell-actions="{ row }">
                        <div
                            class="flex flex-col sm:flex-row items-start sm:items-center gap-1 sm:gap-2"
                        >
                            <Link
                                :href="route('supplier-invoices.show', row.id)"
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
                                :href="route('supplier-invoices.edit', row.id)"
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
                                @click.prevent="destroyInvoice(row.id)"
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
        </div>
    </AppLayout>
</template>
