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
                class="text-3xl font-extrabold text-cyan-900 dark:text-cyan-100 tracking-tight mb-2 flex items-center gap-2"
            >
                <svg
                    v-if="type === 'client'"
                    class="w-7 h-7 text-cyan-600"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <circle cx="12" cy="8" r="4" />
                    <path d="M4 20c0-3.3137 3.134-6 8-6s8 2.6863 8 6" />
                </svg>
                <svg
                    v-else-if="type === 'supplier'"
                    class="w-9 h-9 text-cyan-600"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <rect x="2" y="7" width="13" height="8" rx="2" />
                    <path
                        d="M15 11h3.28a2 2 0 0 1 1.92 1.44l1.1 3.3A1 1 0 0 1 20.36 17H19a2 2 0 1 1-4 0H9a2 2 0 1 1-4 0H3.64a1 1 0 0 1-.94-1.26l1.1-3.3A2 2 0 0 1 5.72 11H9v-2a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2z"
                    />
                    <circle cx="7" cy="17" r="2" />
                    <circle cx="17" cy="17" r="2" />
                </svg>
                <svg
                    v-else
                    class="w-7 h-7 text-cyan-600"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    viewBox="0 0 24 24"
                >
                    <rect x="4" y="4" width="16" height="16" rx="4" />
                    <path d="M8 8h8v8H8z" />
                </svg>
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
            <div
                class="overflow-x-auto rounded-xl shadow bg-transparent dark:bg-transparent"
            >
                <DataTable
                    :columns="[
                        {
                            key: 'nif',
                            label: 'NIF',
                            class: 'hidden xs:table-cell',
                        },
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
                    table-class="min-w-full divide-y divide-gray-200 dark:divide-slate-700"
                    head-class="bg-cyan-50 dark:bg-slate-800 text-cyan-900 dark:text-cyan-100 text-sm font-bold"
                    row-class="hover:bg-cyan-50 dark:hover:bg-slate-800 transition"
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
                                :href="route('entities.edit', row.id)"
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
                                @click.prevent="deleteEntity(row.id)"
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
