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
                class="text-3xl font-extrabold text-cyan-900 dark:text-cyan-100 tracking-tight mb-2 flex items-center gap-2"
            >
                <svg
                    class="w-8 h-8 text-cyan-600"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <rect x="3" y="5" width="18" height="14" rx="2" />
                    <path d="M8 3v2m8-2v2M3 9h18" />
                </svg>
                Logs
            </h2>
        </template>
        <div class="py-6 max-w-6xl mx-auto">
            <div
                class="overflow-x-auto rounded-xl shadow bg-white/80 dark:bg-slate-800/80"
            >
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
                    table-class="min-w-full divide-y divide-gray-200 dark:divide-slate-700"
                    head-class="bg-cyan-50 dark:bg-slate-800 text-cyan-900 dark:text-cyan-100 text-sm font-bold"
                    row-class="hover:bg-cyan-50 dark:hover:bg-slate-800 transition"
                >
                    <template #cell-actions="{ row }">
                        <button
                            @click="deleteLog(row.id)"
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
                    </template>
                </DataTable>
            </div>
        </div>
        <div class="mt-4 flex justify-center mb-2">
            <template v-for="link in logs.links" :key="link.url || link.label">
                <button
                    v-if="link.url"
                    :class="[
                        'px-3 py-1 mx-1 rounded-lg font-semibold transition',
                        link.active
                            ? 'bg-cyan-700 text-white shadow'
                            : 'bg-gray-100 dark:bg-slate-700 text-gray-700 dark:text-gray-200 hover:bg-cyan-50 dark:hover:bg-slate-800',
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
