<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { usePage, router } from "@inertiajs/vue3";
const page = usePage();
const event = page.props.event || {};

const editEvent = () => {
    if (event.id) {
        router.visit(route("calendar.edit", event.id));
    }
};

const deleteEvent = () => {
    if (event.id && confirm("Tem a certeza que deseja apagar este evento?")) {
        router.delete(route("calendar.destroy", event.id), {
            onSuccess: () => {
                router.visit(route("calendar.index"));
            },
        });
    }
};

const goBack = () => {
    if (window.history.length > 1) {
        window.history.back();
    } else {
        router.visit(route("calendar.index"));
    }
};
</script>

<template>
    <AppLayout title="Event Details">
        <template #header>
            <h1 class="text-2xl font-bold">Event Details</h1>
        </template>
        <div class="max-w-2xl mx-auto bg-white rounded shadow p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div><b>Date:</b> {{ event.date }}</div>
                <div><b>Time:</b> {{ event.time }}</div>
                <div><b>Duration:</b> {{ event.duration }} min</div>
                <div><b>Share:</b> {{ event.share }}</div>
                <div><b>Awareness:</b> {{ event.awareness }}</div>
                <div><b>Entity:</b> {{ event.entity }}</div>
                <div><b>Type:</b> {{ event.type }}</div>
                <div><b>Action:</b> {{ event.action }}</div>
                <div><b>User:</b> {{ event.user }}</div>
                <div><b>Status:</b> {{ event.status }}</div>
                <div class="md:col-span-2">
                    <b>Description:</b> {{ event.description }}
                </div>
            </div>
            <div class="mt-6 flex gap-2">
                <button class="btn btn-primary" @click="editEvent">Edit</button>
                <button class="btn btn-danger" @click="deleteEvent">
                    Delete
                </button>
                <button class="btn btn-secondary" @click="goBack">Back</button>
            </div>
        </div>
    </AppLayout>
</template>
