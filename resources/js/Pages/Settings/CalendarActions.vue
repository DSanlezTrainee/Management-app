<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { ref, watch } from "vue";
import { router, usePage } from "@inertiajs/vue3";

const page = usePage();
const actions = ref(page.props.actions || []);
const formAction = ref({ id: null, name: "" });

watch(
    () => page.props.actions,
    (val) => {
        if (val) actions.value = val;
    },
);

const submitAction = () => {
    if (formAction.value.id) {
        router.put(
            `/calendar-actions/${formAction.value.id}`,
            formAction.value,
            {
                onSuccess: () => {
                    router.reload({ only: ["actions"] });
                    resetAction();
                },
            },
        );
    } else {
        router.post("/calendar-actions", formAction.value, {
            onSuccess: () => {
                router.reload({ only: ["actions"] });
                resetAction();
            },
        });
    }
};

const editAction = (action) => {
    formAction.value = { ...action };
};

const resetAction = () => {
    formAction.value = { id: null, name: "" };
};

const deleteAction = (id) => {
    if (confirm("Delete this action?")) {
        router.delete(`/calendar-actions/${id}`, {
            onSuccess: () => router.reload({ only: ["actions"] }),
        });
    }
};
</script>

<template>
    <AppLayout title="Calendar Actions">
        <template #header>
            <h1
                class="text-3xl font-extrabold text-cyan-900 dark:text-cyan-100 tracking-tight mb-6"
            >
                Calendar Actions
            </h1>
        </template>

        <form @submit.prevent="submitAction" class="mb-6">
            <div
                class="flex flex-col md:flex-row gap-2 items-center bg-white/80 dark:bg-slate-800/80 p-4 rounded-xl shadow"
            >
                <input
                    v-model="formAction.name"
                    placeholder="Action name"
                    class="w-full md:w-auto flex-1 rounded-lg border-gray-300 focus:ring-2 focus:ring-cyan-400 focus:border-cyan-400 transition px-3 py-2"
                    required
                />
                <button
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-cyan-700 text-white font-semibold shadow hover:bg-cyan-800 transition-all duration-150 focus:outline-none focus-visible:ring-2 focus-visible:ring-cyan-400"
                >
                    {{ formAction.id ? "Update" : "Add" }}
                </button>
                <button
                    v-if="formAction.id"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-gray-400 text-white font-semibold shadow hover:bg-gray-500 transition-all duration-150 focus:outline-none focus-visible:ring-2 focus-visible:ring-gray-300"
                    type="button"
                    @click="resetAction"
                >
                    Cancel
                </button>
            </div>
        </form>
        <div
            class="overflow-x-auto rounded-xl shadow bg-white/80 dark:bg-slate-800/80"
        >
            <table
                class="min-w-full divide-y divide-gray-200 dark:divide-slate-700"
            >
                <thead
                    class="bg-cyan-50 dark:bg-slate-800 text-cyan-900 dark:text-cyan-100 text-sm font-bold"
                >
                    <tr>
                        <th class="px-4 py-2 text-left">Name</th>
                        <th class="px-4 py-2 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="action in actions"
                        :key="action.id"
                        class="hover:bg-cyan-50 dark:hover:bg-slate-800 transition"
                    >
                        <td class="px-4 py-2">{{ action.name }}</td>
                        <td class="px-4 py-2">
                            <button
                                class="inline-flex items-center gap-2 px-3 py-1 rounded bg-yellow-500 text-white font-semibold shadow hover:bg-yellow-600 transition-all duration-150 focus:outline-none focus-visible:ring-2 focus-visible:ring-yellow-300 mr-2"
                                @click="editAction(action)"
                            >
                                Edit
                            </button>
                            <button
                                class="inline-flex items-center gap-2 px-3 py-1 rounded bg-red-600 text-white font-semibold shadow hover:bg-red-700 transition-all duration-150 focus:outline-none focus-visible:ring-2 focus-visible:ring-red-400"
                                @click="deleteAction(action.id)"
                            >
                                Delete
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </AppLayout>
</template>
