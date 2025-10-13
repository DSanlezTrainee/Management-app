<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { ref, watch } from "vue";
import { router, usePage } from "@inertiajs/vue3";

const page = usePage();
const types = ref(page.props.types || []);
const formType = ref({ id: null, name: "", color: "#000000" });

watch(
    () => page.props.types,
    (val) => {
        if (val) types.value = val;
    },
);

const submitType = () => {
    if (formType.value.id) {
        router.put(`/calendar-types/${formType.value.id}`, formType.value, {
            onSuccess: () => {
                router.reload({ only: ["types"] });
                resetType();
            },
        });
    } else {
        router.post("/calendar-types", formType.value, {
            onSuccess: () => {
                router.reload({ only: ["types"] });
                resetType();
            },
        });
    }
};

const editType = (type) => {
    formType.value = { ...type };
};

const resetType = () => {
    formType.value = { id: null, name: "", color: "#000000" };
};

const deleteType = (id) => {
    if (confirm("Delete this type?")) {
        router.delete(`/calendar-types/${id}`, {
            onSuccess: () => router.reload({ only: ["types"] }),
        });
    }
};
</script>

<template>
    <AppLayout title="Calendar Types">
        <template #header>
            <h1 class="text-2xl font-bold">Calendar Types</h1>
        </template>

        <form @submit.prevent="submitType">
            <div class="flex gap-2 mb-2">
                <input
                    v-model="formType.name"
                    placeholder="Type name"
                    class="input input-bordered"
                    required
                />
                <input
                    v-model="formType.color"
                    type="color"
                    class="input input-bordered w-12 p-0"
                    required
                />
                <button class="btn btn-primary">
                    {{ formType.id ? "Update" : "Add" }}
                </button>
                <button
                    v-if="formType.id"
                    class="btn btn-secondary"
                    type="button"
                    @click="resetType"
                >
                    Cancel
                </button>
            </div>
        </form>
        <table class="table w-full">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Color</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="type in types" :key="type.id">
                    <td>{{ type.name }}</td>
                    <td>
                        <span
                            :style="{
                                background: type.color,
                                display: 'inline-block',
                                width: '24px',
                                height: '24px',
                                borderRadius: '4px',
                            }"
                        ></span>
                    </td>
                    <td>
                        <button
                            class="btn btn-xs btn-info"
                            @click="editType(type)"
                        >
                            Edit
                        </button>
                        <button
                            class="btn btn-xs btn-error"
                            @click="deleteType(type.id)"
                        >
                            Delete
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </AppLayout>
</template>
