<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link } from "@inertiajs/vue3";

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
            <div class="mb-4 flex justify-end">
                <Link
                    :href="route('entities.create')"
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
            <div class="overflow-x-auto">
                <table
                    class="min-w-full bg-white dark:bg-gray-900 rounded shadow"
                >
                    <thead>
                        <tr>
                            <th class="px-4 py-2">NIF</th>
                            <th class="px-4 py-2">Name</th>
                            <th class="px-4 py-2">Phone</th>
                            <th class="px-4 py-2">Mobile</th>
                            <th class="px-4 py-2">Website</th>
                            <th class="px-4 py-2">Email</th>
                            <th class="px-4 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="entity in entities.data" :key="entity.id">
                            <td class="border px-4 py-2">{{ entity.nif }}</td>
                            <td class="border px-4 py-2">{{ entity.name }}</td>
                            <td class="border px-4 py-2">{{ entity.phone }}</td>
                            <td class="border px-4 py-2">
                                {{ entity.mobile }}
                            </td>
                            <td class="border px-4 py-2">
                                {{ entity.website }}
                            </td>
                            <td class="border px-4 py-2">{{ entity.email }}</td>
                            <td class="border px-4 py-2">
                                <Link
                                    :href="route('entities.show', entity.id)"
                                    class="text-blue-600 hover:underline mr-2"
                                    >View</Link
                                >
                                <Link
                                    :href="route('entities.edit', entity.id)"
                                    class="text-yellow-600 hover:underline mr-2"
                                    >Edit</Link
                                >
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>
