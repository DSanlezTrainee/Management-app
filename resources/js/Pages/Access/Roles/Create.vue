<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { useForm, usePage } from "@inertiajs/vue3";
import {
    FormField,
    FormItem,
    FormLabel,
    FormControl,
} from "@/Components/ui/form";
import {
    Select,
    SelectItem,
    SelectContent,
    SelectTrigger,
    SelectValue,
} from "@/Components/ui/select";
import TextInput from "@/Components/TextInput.vue";

const { errors } = usePage().props;

import { computed } from "vue";
const props = defineProps({
    permissions: Array,
});

// Filtra apenas as permissões 'all' e 'read'
const filteredPermissions = computed(() =>
    props.permissions.filter((p) => ["all", "read"].includes(p.name)),
);

const form = useForm({
    name: "",
    status: "active",
    permissions: [],
});

function submit() {
    form.post(route("roles.store"));
}
</script>

<template>
    <AppLayout title="Create Permission Group">
        <template #header>
            <h2
                class="text-3xl font-extrabold text-cyan-900 dark:text-cyan-100 tracking-tight mb-6"
            >
                Create Permission Group
            </h2>
        </template>
        <div class="py-6 max-w-3xl mx-auto">
            <form @submit.prevent="submit" class="space-y-8">
                <div
                    v-if="form.errors.error || errors.error"
                    class="text-red-500 mb-4"
                >
                    <div v-if="errors.error">{{ errors.error }}</div>
                    <div v-if="form.errors.error">{{ form.errors.error }}</div>
                </div>
                <div
                    class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6 items-start bg-white/80 dark:bg-slate-800/80 p-6 rounded-xl shadow"
                >
                    <div class="flex flex-col gap-1 w-full">
                        <FormField name="name">
                            <FormItem class="w-full">
                                <FormLabel>Group Name</FormLabel>
                                <FormControl>
                                    <TextInput
                                        v-model="form.name"
                                        required
                                        class="w-full"
                                    />
                                </FormControl>
                                <p
                                    v-if="form.errors.name"
                                    class="text-sm text-red-600 mt-1"
                                >
                                    {{ form.errors.name }}
                                </p>
                            </FormItem>
                        </FormField>
                    </div>
                    <div class="flex flex-col gap-1 w-full">
                        <FormField name="status">
                            <FormItem class="w-full">
                                <FormLabel>Status</FormLabel>
                                <FormControl>
                                    <div class="w-full relative">
                                        <Select v-model="form.status">
                                            <SelectTrigger
                                                class="w-full bg-white"
                                            >
                                                <SelectValue
                                                    placeholder="Select status"
                                                />
                                            </SelectTrigger>
                                            <SelectContent class="bg-white">
                                                <SelectItem value="active"
                                                    >Active</SelectItem
                                                >
                                                <SelectItem value="inactive"
                                                    >Inactive</SelectItem
                                                >
                                            </SelectContent>
                                        </Select>
                                    </div>
                                </FormControl>
                                <p
                                    v-if="form.errors.status"
                                    class="text-sm text-red-600 mt-1"
                                >
                                    {{ form.errors.status }}
                                </p>
                            </FormItem>
                        </FormField>
                    </div>
                    <div class="flex flex-col gap-1 w-full md:col-span-2">
                        <FormField name="permissions">
                            <FormItem class="w-full">
                                <FormLabel>Permissions</FormLabel>
                                <FormControl>
                                    <div class="flex flex-col gap-2">
                                        <label
                                            v-for="permission in filteredPermissions"
                                            :key="permission.name"
                                            class="flex items-center gap-2"
                                        >
                                            <input
                                                type="checkbox"
                                                :value="permission.name"
                                                v-model="form.permissions"
                                            />
                                            <span class="capitalize">{{
                                                permission.name
                                            }}</span>
                                        </label>
                                    </div>
                                </FormControl>
                                <p
                                    v-if="form.errors.permissions"
                                    class="text-sm text-red-600 mt-1"
                                >
                                    {{ form.errors.permissions }}
                                </p>
                            </FormItem>
                        </FormField>
                    </div>
                </div>
                <div class="col-span-1 md:col-span-2 mt-8 flex justify-end">
                    <button
                        type="submit"
                        class="inline-flex items-center gap-2 px-6 py-2 rounded-lg bg-cyan-700 text-white font-semibold shadow hover:bg-cyan-800 transition-all duration-150 focus:outline-none focus-visible:ring-2 focus-visible:ring-cyan-400"
                        :disabled="form.processing"
                    >
                        {{ form.processing ? "Creating..." : "Create" }}
                    </button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
