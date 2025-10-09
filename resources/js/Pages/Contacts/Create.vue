<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { ref, computed } from "vue";
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

const page = usePage();
const backendErrors = page.props.errors || {};

const props = defineProps({
    entities: Array,
    functions: Array,
});


const form = useForm({
    first_name: "",
    last_name: "",
    entity_id: "",
    contact_function_id: "",
    email: "",
    phone: "",
    mobile: "",
    rgpd_consent: false,
    notes: "",
    status: "active",
});

function submit() {
    form.post(route("contacts.store"));
}
</script>

<template>
    <AppLayout title="Create Contact">
        <form @submit.prevent="submit" class="max-w-2xl mx-auto space-y-4">
            <div
                class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4 items-start"
            >
                <FormField name="first_name">
                    <FormItem class="w-full">
                        <FormLabel>First Name</FormLabel>
                        <FormControl>
                            <TextInput
                                v-model="form.first_name"
                                required
                                class="w-full"
                            />
                        </FormControl>
                        <p
                            v-if="
                                form.errors.first_name ||
                                backendErrors.first_name
                            "
                            class="text-sm text-red-600 mt-1"
                        >
                            {{
                                form.errors.first_name ||
                                backendErrors.first_name
                            }}
                        </p>
                    </FormItem>
                </FormField>
                <FormField name="last_name">
                    <FormItem class="w-full">
                        <FormLabel>Last Name</FormLabel>
                        <FormControl>
                            <TextInput
                                v-model="form.last_name"
                                required
                                class="w-full"
                            />
                        </FormControl>
                        <p
                            v-if="
                                form.errors.last_name || backendErrors.last_name
                            "
                            class="text-sm text-red-600 mt-1"
                        >
                            {{
                                form.errors.last_name || backendErrors.last_name
                            }}
                        </p>
                    </FormItem>
                </FormField>
                <FormField name="entity_id">
                    <FormItem class="w-full">
                        <FormLabel>Entity</FormLabel>
                        <FormControl>
                            <div class="w-full relative">
                                <Select v-model="form.entity_id" required>
                                    <SelectTrigger class="w-full bg-white">
                                        <SelectValue
                                            placeholder="Select entity"
                                        />
                                    </SelectTrigger>
                                    <SelectContent class="bg-white">
                                        <SelectItem
                                            v-for="entity in entities"
                                            :key="entity.id"
                                            :value="entity.id"
                                        >
                                            {{ entity.name }}
                                        </SelectItem>
                                    </SelectContent>
                                </Select>
                            </div>
                        </FormControl>
                        <p
                            v-if="
                                form.errors.entity_id || backendErrors.entity_id
                            "
                            class="text-sm text-red-600 mt-1"
                        >
                            {{
                                form.errors.entity_id || backendErrors.entity_id
                            }}
                        </p>
                    </FormItem>
                </FormField>
                <FormField name="contact_function_id">
                    <FormItem class="w-full">
                        <FormLabel>Function</FormLabel>
                        <FormControl>
                            <div class="w-full relative">
                                <Select
                                    v-model="form.contact_function_id"
                                    required
                                >
                                    <SelectTrigger class="w-full bg-white">
                                        <SelectValue
                                            placeholder="Select function"
                                        />
                                    </SelectTrigger>
                                    <SelectContent class="bg-white">
                                        <SelectItem
                                            v-for="fn in functions"
                                            :key="fn.id"
                                            :value="fn.id"
                                        >
                                            {{ fn.name }}
                                        </SelectItem>
                                    </SelectContent>
                                </Select>
                            </div>
                        </FormControl>
                        <p
                            v-if="
                                form.errors.contact_function_id ||
                                backendErrors.contact_function_id
                            "
                            class="text-sm text-red-600 mt-1"
                        >
                            {{
                                form.errors.contact_function_id ||
                                backendErrors.contact_function_id
                            }}
                        </p>
                    </FormItem>
                </FormField>
                <FormField name="phone">
                    <FormItem class="w-full">
                        <FormLabel>Phone</FormLabel>
                        <FormControl>
                            <TextInput v-model="form.phone" class="w-full" />
                        </FormControl>
                        <p
                            v-if="form.errors.phone || backendErrors.phone"
                            class="text-sm text-red-600 mt-1"
                        >
                            {{ form.errors.phone || backendErrors.phone }}
                        </p>
                    </FormItem>
                </FormField>
                <FormField name="mobile">
                    <FormItem class="w-full">
                        <FormLabel>Mobile</FormLabel>
                        <FormControl>
                            <TextInput
                                v-model="form.mobile"
                                class="w-full"
                                required
                            />
                        </FormControl>
                        <p
                            v-if="form.errors.mobile || backendErrors.mobile"
                            class="text-sm text-red-600 mt-1"
                        >
                            {{ form.errors.mobile || backendErrors.mobile }}
                        </p>
                    </FormItem>
                </FormField>
                <FormField name="email">
                    <FormItem class="w-full">
                        <FormLabel>Email</FormLabel>
                        <FormControl>
                            <TextInput
                                v-model="form.email"
                                type="email"
                                class="w-full"
                                required
                            />
                        </FormControl>
                        <p
                            v-if="form.errors.email || backendErrors.email"
                            class="text-sm text-red-600 mt-1"
                        >
                            {{ form.errors.email || backendErrors.email }}
                        </p>
                    </FormItem>
                </FormField>
                <FormField name="status">
                    <FormItem class="w-full">
                        <FormLabel>Status</FormLabel>
                        <FormControl>
                            <div class="w-full relative">
                                <Select v-model="form.status" required>
                                    <SelectTrigger class="w-full bg-white">
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
                            v-if="form.errors.status || backendErrors.status"
                            class="text-sm text-red-600 mt-1"
                        >
                            {{ form.errors.status || backendErrors.status }}
                        </p>
                    </FormItem>
                </FormField>
                <FormField name="notes">
                    <FormItem class="w-full md:col-span-2">
                        <FormLabel>Notes</FormLabel>
                        <FormControl>
                            <textarea
                                v-model="form.notes"
                                class="input w-full"
                            ></textarea>
                        </FormControl>
                        <p
                            v-if="form.errors.notes || backendErrors.notes"
                            class="text-sm text-red-600 mt-1"
                        >
                            {{ form.errors.notes || backendErrors.notes }}
                        </p>
                    </FormItem>
                </FormField>
                <FormField name="rgpd_consent">
                    <FormItem
                        class="w-full flex items-center gap-2 md:col-span-2"
                    >
                        <FormLabel class="mb-0">RGPD Consent</FormLabel>
                        <FormControl>
                            <input
                                type="checkbox"
                                v-model="form.rgpd_consent"
                                class="h-4 w-4"
                            />
                        </FormControl>
                        <p
                            v-if="
                                form.errors.rgpd_consent ||
                                backendErrors.rgpd_consent
                            "
                            class="text-sm text-red-600 mt-1"
                        >
                            {{
                                form.errors.rgpd_consent ||
                                backendErrors.rgpd_consent
                            }}
                        </p>
                    </FormItem>
                </FormField>
            </div>
            <div class="col-span-1 md:col-span-2 mt-8 flex justify-end">
                <button
                    type="submit"
                    class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition"
                    :disabled="form.processing"
                >
                    {{ form.processing ? "Creating..." : "Create" }}
                </button>
            </div>
        </form>
    </AppLayout>
</template>
