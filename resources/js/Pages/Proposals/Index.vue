<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link, router, usePage } from "@inertiajs/vue3";
import DataTable from "@/Components/ui/table/DataTable.vue";
import { ref, watch, onMounted } from "vue";

const props = defineProps({
    proposals: Object,
});

const page = usePage();
const { errors } = usePage().props;
const showFlash = ref(false);

function deleteProposal(id) {
    if (confirm("Are you sure you want to delete this proposal?")) {
        router.delete(route("proposals.destroy", id));
    }
}

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

// Watch for changes in flash messages
watch(
    () => page.props.flash,
    (newFlash) => {
        if (newFlash && (newFlash.success || newFlash.error)) {
            startFlashTimer();
        }
    },
    { deep: true },
);

function formatPrice(p) {
    const n = Number(p);
    if (Number.isInteger(n)) return n + "€";
    return (
        n.toLocaleString(undefined, {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2,
        }) + "€"
    );
}
</script>

<template>
    <AppLayout title="Proposals">
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                Proposals
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
                    :href="route('proposals.create')"
                    class="w-full sm:w-auto px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
                >
                    New Proposal
                </Link>
            </div>
            <div v-if="errors.error" class="text-red-500 mb-4">
                {{ errors.error }}
            </div>
            <DataTable
                :columns="[
                    { key: 'date', label: 'Date' },
                    { key: 'number', label: 'Number' },
                    { key: 'valid_until', label: 'Valid Until' },
                    { key: 'client', label: 'Client' },
                    { key: 'total', label: 'Total Value' },
                    { key: 'status', label: 'Status' },
                    { key: 'actions', label: 'Actions' },
                ]"
                :data="proposals.data"
            >
                <template #cell-client="{ row }">
                    {{ row.client?.name || "-" }}
                </template>
                <template #cell-total="{ row }">
                    {{ formatPrice(row.total) }}
                </template>
                <template #cell-actions="{ row }">
                    <div
                        class="flex flex-col sm:flex-row items-start sm:items-center gap-1 sm:gap-2"
                    >
                        <Link
                            :href="route('proposals.show', row.id)"
                            class="text-blue-600 hover:underline"
                            >View</Link
                        >
                        <Link
                            :href="route('proposals.edit', row.id)"
                            class="text-yellow-600 hover:underline"
                            >Edit</Link
                        >
                        <button
                            @click.prevent="deleteProposal(row.id)"
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
