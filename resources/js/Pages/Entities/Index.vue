<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link } from "@inertiajs/vue3";

import DataTable from "@/Components/ui/table/DataTable.vue";

defineProps({
    entities: Array,
    type: String,
});
</script>

<template>
    <AppLayout
        :title="
            type === 'client'
                ? 'Clients'
                : type === 'supplier'
                  ? 'Suppliers'
                  : 'Entities'
        "
    >
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                {{
                    type === "client"
                        ? "Clients"
                        : type === "supplier"
                          ? "Suppliers"
                          : "Entities"
                }}
            </h2>
        </template>
        <div class="py-6">
            <div class="mb-10 flex justify-end">
                <Link
                    :href="
                        route('entities.create') + (type ? `?type=${type}` : '')
                    "
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
                >
                    New
                    {{
                        type === "client"
                            ? "Client"
                            : type === "supplier"
                              ? "Supplier"
                              : "Entity"
                    }}
                </Link>
            </div>
            <DataTable
                :columns="[
                    { key: 'nif', label: 'NIF' },
                    { key: 'name', label: 'Name' },
                    { key: 'address', label: 'Address' },
                    { key: 'postal_code', label: 'Postal Code' },
                    { key: 'city', label: 'City' },
                    { key: 'country', label: 'Country' },
                    { key: 'phone', label: 'Phone' },
                    { key: 'mobile', label: 'Mobile' },
                    { key: 'website', label: 'Website' },
                    { key: 'email', label: 'Email' },
                    { key: 'actions', label: 'Actions' },
                ]"
                :data="entities.data"
            >
                <template #cell-country="{ row }">
                    {{ row.country?.name || "-" }}
                </template>
                <template #cell-actions="{ row }">
                    <Link
                        :href="route('entities.show', row.id)"
                        class="text-blue-600 hover:underline mr-2"
                        >View</Link
                    >
                    <Link
                        :href="route('entities.edit', row.id)"
                        class="text-yellow-600 hover:underline mr-2"
                        >Edit</Link
                    >
                </template>
            </DataTable>
        </div>
    </AppLayout>
</template>
