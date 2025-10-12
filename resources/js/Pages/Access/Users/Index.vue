<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link, router, usePage } from "@inertiajs/vue3";
import DataTable from "@/Components/ui/table/DataTable.vue";
import { ref, watch, onMounted } from "vue";

const props = defineProps({
    users: Object,
    roles: Array,
});

const page = usePage();
const { errors } = usePage().props;
const showFlash = ref(false);

function deleteUser(id) {
    if (confirm("Are you sure you want to delete this user?")) {
        router.delete(route("users.destroy", id));
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

watch(
    () => page.props.flash,
    (newFlash) => {
        if (newFlash && (newFlash.success || newFlash.error)) {
            startFlashTimer();
        }
    },
    { deep: true },
);
</script>

<template>
    <AppLayout title="Access Management - Users">
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                Access Management - Users
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
                    :href="route('users.create')"
                    class="w-full sm:w-auto px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
                >
                    New User
                </Link>
            </div>
            <div v-if="errors && errors.error" class="text-red-500 mb-4">
                {{ errors.error }}
            </div>
            <DataTable
                :columns="[
                    { key: 'name', label: 'Name' },
                    { key: 'email', label: 'Email' },
                    { key: 'mobile', label: 'Mobile' },
                    { key: 'role', label: 'Role' },
                    { key: 'status', label: 'Status' },
                    { key: 'actions', label: 'Actions' },
                ]"
                :data="users.data"
            >
                <template #cell-role="{ row }">
                    {{ row.role?.name || "-" }}
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
                            :href="route('users.show', row.id)"
                            class="text-blue-600 hover:underline"
                            >View</Link
                        >
                        <Link
                            :href="route('users.edit', row.id)"
                            class="text-yellow-600 hover:underline"
                            >Edit</Link
                        >
                        <button
                            @click.prevent="deleteUser(row.id)"
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
