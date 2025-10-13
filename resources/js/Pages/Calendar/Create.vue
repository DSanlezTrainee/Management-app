<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { router, usePage } from "@inertiajs/vue3";
import { ref } from "vue";

const page = usePage();
const entities = page.props.entities || [];
const users = page.props.users || [];
const types = page.props.types || [];
const actions = page.props.actions || [];

const form = ref({
    date: "",
    time: "",
    duration: "",
    share: "",
    awareness: "",
    entity_id: "",
    type_id: "",
    action_id: "",
    user_id: "",
    description: "",
    status: "",
});

const submit = () => {
    router.post(route("calendar.store"), form.value);
};

const cancel = () => {
    if (window.history.length > 1) {
        window.history.back();
    } else {
        router.visit(route("calendar.index"));
    }
};
</script>

<template>
    <AppLayout title="New Event">
        <template #header>
            <h1 class="text-2xl font-bold">New Event</h1>
        </template>
        <div class="max-w-2xl mx-auto bg-white rounded shadow p-6">
            <form @submit.prevent="submit">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-semibold mb-1">Date</label>
                        <input
                            v-model="form.date"
                            type="date"
                            class="input input-bordered w-full"
                            required
                        />
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">Time</label>
                        <input
                            v-model="form.time"
                            type="time"
                            class="input input-bordered w-full"
                            required
                        />
                    </div>
                    <div>
                        <label class="block font-semibold mb-1"
                            >Duration (minutes)</label
                        >
                        <input
                            v-model="form.duration"
                            type="number"
                            min="0"
                            class="input input-bordered w-full"
                        />
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">Share</label>
                        <input
                            v-model="form.share"
                            type="text"
                            class="input input-bordered w-full"
                        />
                    </div>
                    <div>
                        <label class="block font-semibold mb-1"
                            >Awareness</label
                        >
                        <input
                            v-model="form.awareness"
                            type="text"
                            class="input input-bordered w-full"
                        />
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">Entity</label>
                        <select
                            v-model="form.entity_id"
                            class="input input-bordered w-full"
                        >
                            <option value="">--</option>
                            <option
                                v-for="e in entities"
                                :key="e.id"
                                :value="e.id"
                            >
                                {{ e.name }}
                            </option>
                        </select>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">Type</label>
                        <select
                            v-model="form.type_id"
                            class="input input-bordered w-full"
                        >
                            <option value="">--</option>
                            <option
                                v-for="t in types"
                                :key="t.id"
                                :value="t.id"
                            >
                                {{ t.name }}
                            </option>
                        </select>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">Action</label>
                        <select
                            v-model="form.action_id"
                            class="input input-bordered w-full"
                        >
                            <option value="">--</option>
                            <option
                                v-for="a in actions"
                                :key="a.id"
                                :value="a.id"
                            >
                                {{ a.name }}
                            </option>
                        </select>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">User</label>
                        <select
                            v-model="form.user_id"
                            class="input input-bordered w-full"
                        >
                            <option value="">--</option>
                            <option
                                v-for="u in users"
                                :key="u.id"
                                :value="u.id"
                            >
                                {{ u.name }}
                            </option>
                        </select>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block font-semibold mb-1"
                            >Description</label
                        >
                        <textarea
                            v-model="form.description"
                            class="input input-bordered w-full"
                            rows="2"
                        ></textarea>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block font-semibold mb-1">Status</label>
                        <input
                            v-model="form.status"
                            type="text"
                            class="input input-bordered w-full"
                        />
                    </div>
                </div>
                <div class="mt-6 flex gap-2">
                    <button
                        type="button"
                        class="btn btn-secondary"
                        @click="cancel"
                    >
                        Cancel
                    </button>
                    <button class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
