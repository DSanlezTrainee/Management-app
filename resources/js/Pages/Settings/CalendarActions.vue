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
            <h1 class="text-2xl font-bold">Calendar Actions</h1>
        </template>

        <form @submit.prevent="submitAction">
            <div class="flex gap-2 mb-2">
                <input
                    v-model="formAction.name"
                    placeholder="Action name"
                    class="input input-bordered"
                    required
                />
                <button class="btn btn-primary">
                    {{ formAction.id ? "Update" : "Add" }}
                </button>
                <button
                    v-if="formAction.id"
                    class="btn btn-secondary"
                    type="button"
                    @click="resetAction"
                >
                    Cancel
                </button>
            </div>
        </form>
        <table class="table w-full">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="action in actions" :key="action.id">
                    <td>{{ action.name }}</td>
                    <td>
                        <button
                            class="btn btn-xs btn-info"
                            @click="editAction(action)"
                        >
                            Edit
                        </button>
                        <button
                            class="btn btn-xs btn-error"
                            @click="deleteAction(action.id)"
                        >
                            Delete
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </AppLayout>
</template>
