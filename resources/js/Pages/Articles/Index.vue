<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link, router, usePage } from "@inertiajs/vue3";
import DataTable from "@/Components/ui/table/DataTable.vue";

const props = defineProps({
    articles: Object,
    vatRates: Array,
});

const { errors } = usePage().props;

function deleteArticle(id) {
    if (confirm("Are you sure you want to delete this article?")) {
        router.delete(route("articles.destroy", id));
    }
}
</script>

<template>
    <AppLayout title="Articles">
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                Articles
            </h2>
        </template>
        <div class="py-6">
            <div class="mb-10 flex justify-end">
                <Link
                    :href="route('articles.create')"
                    class="w-full sm:w-auto px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
                >
                    New Article
                </Link>
            </div>
            <div v-if="errors.error" class="text-red-500 mb-4">
                {{ errors.error }}
            </div>
            <DataTable
                :columns="[
                    { key: 'reference', label: 'Reference' },
                    { key: 'name', label: 'Name' },
                    { key: 'price', label: 'Price ' },
                    { key: 'vat_rate', label: 'Rate (%)' },
                    { key: 'status', label: 'Status' },
                    { key: 'actions', label: 'Actions' },
                ]"
                :data="articles.data"
            >
                <template #cell-price="{ row }">
                    {{
                        row.vat_rate && row.vat_rate.rate
                            ? (
                                  parseFloat(row.price) *
                                  (1 + parseFloat(row.vat_rate.rate) / 100)
                              ).toFixed(2)
                            : parseFloat(row.price).toFixed(2)
                    }}
                </template>
                <template #cell-vat_rate="{ row }">
                    {{ parseFloat(row.vat_rate?.rate) }}%
                </template>
                <template #cell-status="{ row }">
                    <span
                        :class="row.status ? 'text-green-600' : 'text-gray-400'"
                    >
                        {{ row.status ? "Active" : "Inactive" }}
                    </span>
                </template>
                <template #cell-actions="{ row }">
                    <div
                        class="flex flex-col sm:flex-row items-start sm:items-center gap-1 sm:gap-2"
                    >
                        <Link
                            :href="route('articles.show', row.id)"
                            class="text-blue-600 hover:underline"
                            >View</Link
                        >
                        <Link
                            :href="route('articles.edit', row.id)"
                            class="text-yellow-600 hover:underline"
                            >Edit</Link
                        >
                        <button
                            @click.prevent="deleteArticle(row.id)"
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
