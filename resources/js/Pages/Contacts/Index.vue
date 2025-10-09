<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link, router } from "@inertiajs/vue3";
import DataTable from "@/Components/ui/table/DataTable.vue";

defineProps({
    contacts: Object,
});

function deleteContact(id) {
    if (confirm("Are you sure you want to delete this contact?")) {
        router.delete(route("contacts.destroy", id));
    }
}
</script>

<template>
    <AppLayout title="Contacts">
        <div class="mb-10 flex justify-end sm:justify-end">
            <Link
                :href="route('contacts.create')"
                class="w-full sm:w-auto px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
            >
                New Contact
            </Link>
        </div>
        <DataTable
            :columns="[
                { key: 'first_name', label: 'Name' },
                { key: 'last_name', label: 'Last Name' },
                 { key: 'entity', label: 'Entity' },
                { key: 'contact_function', label: 'Function' },         
                { key: 'phone', label: 'Phone' },
                { key: 'mobile', label: 'Mobile' },
                { key: 'email', label: 'Email' },
                { key: 'actions', label: 'Actions' },
            ]"
            :data="contacts.data"
        >
            <template #cell-contact_function="{ row }">
                {{ row.contact_function?.name || "-" }}
            </template>
            <template #cell-entity="{ row }">
                {{ row.entity?.name || "-" }}
            </template>
            <template #cell-actions="{ row }">
                <div
                    class="flex flex-col sm:flex-row items-start sm:items-center gap-1 sm:gap-2"
                >
                    <Link
                        :href="route('contacts.show', row.id)"
                        class="text-blue-600 hover:underline"
                        >View</Link
                    >
                    <Link
                        :href="route('contacts.edit', row.id)"
                        class="text-yellow-600 hover:underline"
                        >Edit</Link
                    >
                    <button
                        @click.prevent="deleteContact(row.id)"
                        class="text-red-600 hover:underline"
                    >
                        Delete
                    </button>
                </div>
            </template>
        </DataTable>
    </AppLayout>
</template>
