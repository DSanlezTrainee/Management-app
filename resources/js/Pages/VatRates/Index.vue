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
        <div class="mb-10 flex justify-end">
            <Link
                :href="route('vat-rates.create')"
                class="w-full sm:w-auto px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
            >
                New VAT Rate
            </Link>
        </div>
        <DataTable
            :columns="[
                { key: 'name', label: 'Name' },
                { key: 'rate', label: 'Rate (%)' },
                { key: 'active', label: 'Active' },
                { key: 'actions', label: 'Actions' },
            ]"
            :data="vatRates.data ?? vatRates"
        >
            <template #cell-active="{ row }">
                <span :class="row.active ? 'text-green-600' : 'text-gray-400'">
                    {{ row.active ? "Yes" : "No" }}
                </span>
            </template>
            <template #cell-actions="{ row }">
                <div
                    class="flex flex-col sm:flex-row items-start sm:items-center gap-1 sm:gap-2"
                >
                    <Link
                        :href="route('vat-rates.show', row.id)"
                        class="text-blue-600 hover:underline"
                        >View</Link
                    >
                    <Link
                        :href="route('vat-rates.edit', row.id)"
                        class="text-yellow-600 hover:underline"
                        >Edit</Link
                    >
                    <button
                        @click.prevent="deleteVatRate(row.id)"
                        class="text-red-600 hover:underline"
                    >
                        Delete
                    </button>
                </div>
            </template>
        </DataTable>
    </AppLayout>
</template>
