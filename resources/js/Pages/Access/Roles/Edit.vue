<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { ref, computed } from "vue";
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

const page = usePage();
const backendErrors = computed(() => page.props.errors || {});

const props = defineProps({
    role: Object,
    permissions: Array,
});

const form = useForm({
    name: props.role.name,
    status: props.role.status,
    permissions: props.role.permissions.map((p) => p.name),
});

// Filtra apenas as permissões 'all' e 'read'
const filteredPermissions = computed(() =>
    props.permissions.filter((p) => ["all", "read"].includes(p.name)),
);

function submit() {
    form.put(route("roles.update", props.role.id));
}
</script>

<template>
    <AppLayout title="Edit Permission Group">
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                Edit Permission Group
            </h2>
        </template>
        <div class="py-6 max-w-3xl mx-auto">
            <form @submit.prevent="submit">
                <div
                    v-if="form.errors.error || backendErrors.error"
                    class="text-red-500 mb-4"
                >
                    <div v-if="backendErrors.error">
                        {{ backendErrors.error }}
                    </div>
                    <div v-if="form.errors.error">{{ form.errors.error }}</div>
                </div>
                <div
                    class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4 items-start"
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
                                    v-if="
                                        form.errors.name || backendErrors.name
                                    "
                                    class="text-sm text-red-600 mt-1"
                                >
                                    {{ form.errors.name || backendErrors.name }}
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
                                    v-if="
                                        form.errors.status ||
                                        backendErrors.status
                                    "
                                    class="text-sm text-red-600 mt-1"
                                >
                                    {{
                                        form.errors.status ||
                                        backendErrors.status
                                    }}
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
                                    v-if="
                                        form.errors.permissions ||
                                        backendErrors.permissions
                                    "
                                    class="text-sm text-red-600 mt-1"
                                >
                                    {{
                                        form.errors.permissions ||
                                        backendErrors.permissions
                                    }}
                                </p>
                            </FormItem>
                        </FormField>
                    </div>
                </div>
                <div class="col-span-1 md:col-span-2 mt-8 flex justify-end">
                    <button
                        type="submit"
                        class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition"
                        :disabled="form.processing"
                    >
                        {{ form.processing ? "Saving..." : "Save" }}
                    </button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
