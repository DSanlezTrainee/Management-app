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
    user: Object,
    roles: Array,
});

const form = useForm({
    name: props.user.name,
    email: props.user.email,
    mobile: props.user.mobile,
    role: props.user.role,
    status: props.user.status,
    password: "",
    password_confirmation: "",
});

function submit() {
    form.put(route("users.update", props.user.id));
}
</script>

<template>
    <AppLayout title="Edit User">
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                Edit User
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
                                <FormLabel>Name</FormLabel>
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
                        <FormField name="email">
                            <FormItem class="w-full">
                                <FormLabel>Email</FormLabel>
                                <FormControl>
                                    <TextInput
                                        v-model="form.email"
                                        type="email"
                                        required
                                        class="w-full"
                                    />
                                </FormControl>
                                <p
                                    v-if="
                                        form.errors.email || backendErrors.email
                                    "
                                    class="text-sm text-red-600 mt-1"
                                >
                                    {{
                                        form.errors.email || backendErrors.email
                                    }}
                                </p>
                            </FormItem>
                        </FormField>
                    </div>
                    <div class="flex flex-col gap-1 w-full">
                        <FormField name="mobile">
                            <FormItem class="w-full">
                                <FormLabel>Mobile</FormLabel>
                                <FormControl>
                                    <TextInput
                                        v-model="form.mobile"
                                        required
                                        class="w-full"
                                    />
                                </FormControl>
                                <p
                                    v-if="
                                        form.errors.mobile ||
                                        backendErrors.mobile
                                    "
                                    class="text-sm text-red-600 mt-1"
                                >
                                    {{
                                        form.errors.mobile ||
                                        backendErrors.mobile
                                    }}
                                </p>
                            </FormItem>
                        </FormField>
                    </div>
                    <div class="flex flex-col gap-1 w-full">
                        <FormField name="role">
                            <FormItem class="w-full">
                                <FormLabel>Permission Group</FormLabel>
                                <FormControl>
                                    <div class="w-full relative">
                                        <Select v-model="form.role">
                                            <SelectTrigger
                                                class="w-full bg-white"
                                            >
                                                <SelectValue
                                                    placeholder="Select group"
                                                />
                                            </SelectTrigger>
                                            <SelectContent class="bg-white">
                                                <SelectItem
                                                    v-for="role in props.roles"
                                                    :key="role.id"
                                                    :value="role.name"
                                                >
                                                    {{ role.name }}
                                                </SelectItem>
                                            </SelectContent>
                                        </Select>
                                    </div>
                                </FormControl>
                                <p
                                    v-if="
                                        form.errors.role || backendErrors.role
                                    "
                                    class="text-sm text-red-600 mt-1"
                                >
                                    {{ form.errors.role || backendErrors.role }}
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
                    <div class="flex flex-col gap-1 w-full">
                        <FormField name="password">
                            <FormItem class="w-full">
                                <FormLabel>Password</FormLabel>
                                <FormControl>
                                    <TextInput
                                        v-model="form.password"
                                        type="password"
                                        class="w-full"
                                    />
                                </FormControl>
                                <p
                                    v-if="
                                        form.errors.password ||
                                        backendErrors.password
                                    "
                                    class="text-sm text-red-600 mt-1"
                                >
                                    {{
                                        form.errors.password ||
                                        backendErrors.password
                                    }}
                                </p>
                            </FormItem>
                        </FormField>
                    </div>
                    <div class="flex flex-col gap-1 w-full">
                        <FormField name="password_confirmation">
                            <FormItem class="w-full">
                                <FormLabel>Confirm Password</FormLabel>
                                <FormControl>
                                    <TextInput
                                        v-model="form.password_confirmation"
                                        type="password"
                                        class="w-full"
                                    />
                                </FormControl>
                                <p
                                    v-if="
                                        form.errors.password_confirmation ||
                                        backendErrors.password_confirmation
                                    "
                                    class="text-sm text-red-600 mt-1"
                                >
                                    {{
                                        form.errors.password_confirmation ||
                                        backendErrors.password_confirmation
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
