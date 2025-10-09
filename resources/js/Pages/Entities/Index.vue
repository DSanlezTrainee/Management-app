<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link, router } from "@inertiajs/vue3";

import DataTable from "@/Components/ui/table/DataTable.vue";

defineProps({
    entities: Object,
    type: String,
});

function deleteEntity(id) {
    if (confirm("Are you sure you want to delete this entity?")) {
        router.delete(route("entities.destroy", id));
    }
}
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
            <div class="mb-10 flex justify-end sm:justify-end">
                <Link
                    :href="
                        route('entities.create') + (type ? `?type=${type}` : '')
                    "
                    class="w-full sm:w-auto px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
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
                    { key: 'nif', label: 'NIF', class: 'hidden xs:table-cell' },
                    { key: 'name', label: 'Name' },
                    {
                        key: 'address',
                        label: 'Address',
                        class: 'hidden md:table-cell',
                    },
                    {
                        key: 'postal_code',
                        label: 'Postal Code',
                        class: 'hidden md:table-cell',
                    },
                    {
                        key: 'city',
                        label: 'City',
                        class: 'hidden sm:table-cell',
                    },
                    {
                        key: 'country',
                        label: 'Country',
                        class: 'hidden sm:table-cell',
                    },
                    {
                        key: 'phone',
                        label: 'Phone',
                        class: 'hidden lg:table-cell',
                    },
                    {
                        key: 'mobile',
                        label: 'Mobile',
                        class: 'hidden lg:table-cell',
                    },
                    {
                        key: 'website',
                        label: 'Website',
                        class: 'hidden xl:table-cell',
                    },
                    {
                        key: 'email',
                        label: 'Email',
                        class: 'hidden xl:table-cell',
                    },
                    { key: 'actions', label: 'Actions' },
                ]"
                :data="entities.data"
            >
                <template #cell-country="{ row }">
                    {{ row.country?.name || "-" }}
                </template>
                <template #cell-actions="{ row }">
                    <div
                        class="flex flex-col sm:flex-row items-start sm:items-center gap-1 sm:gap-2"
                    >
                        <Link
                            :href="route('entities.show', row.id)"
                            class="text-blue-600 hover:underline"
                            >View</Link
                        >
                        <Link
                            :href="route('entities.edit', row.id)"
                            class="text-yellow-600 hover:underline"
                            >Edit</Link
                        >
                        <button
                            @click.prevent="deleteEntity(row.id)"
                            class="text-red-600 hover:underline"
                        >
                            Delete
                        </button>
                    </div>
                </template>
            </DataTable>
        </div>
    </AppLayout>
</template>
