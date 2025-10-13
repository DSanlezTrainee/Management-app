<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import DataTable from "@/Components/ui/table/DataTable.vue";
import { usePage, router } from "@inertiajs/vue3";

const props = defineProps({
    logs: Object,
});

function deleteLog(id) {
    if (confirm("Are you sure you want to delete this log?")) {
        router.delete(route("logs.destroy", id));
    }
}
</script>

<template>
    <AppLayout title="Logs">
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                Logs
            </h2>
        </template>
        <div class="py-6 max-w-6xl mx-auto">
            <DataTable
                :columns="[
                    { key: 'date', label: 'Date' },
                    { key: 'time', label: 'Time' },
                    { key: 'user', label: 'User' },
                    { key: 'menu', label: 'Menu' },
                    { key: 'action', label: 'Action' },
                    { key: 'device', label: 'Device' },
                    { key: 'ip', label: 'IP' },
                    { key: 'actions', label: 'Actions' },
                ]"
                :data="logs.data"
            >
                <template #cell-actions="{ row }">
                    <button
                        @click="deleteLog(row.id)"
                        class="text-red-600 hover:underline"
                    >
                        delete
                    </button>
                </template>
            </DataTable>
        </div>
        <div class="mt-4 flex justify-center mb-2">
            <template v-for="link in logs.links" :key="link.url || link.label">
                <button
                    v-if="link.url"
                    :class="[
                        'px-3 py-1 mx-1 rounded',
                        { 'bg-gray-200 font-bold': link.active },
                    ]"
                    @click="router.visit(link.url)"
                    v-html="link.label"
                />
                <span
                    v-else
                    v-html="link.label"
                    class="px-3 py-1 mx-1 text-gray-400"
                />
            </template>
        </div>
    </AppLayout>
</template>
