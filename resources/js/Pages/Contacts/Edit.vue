<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import TextInput from "@/Components/TextInput.vue";
import { useForm } from "@inertiajs/vue3";
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

const props = defineProps({
    contact: Object,
    entities: Array,
    functions: Array,
});

const form = useForm({
    first_name: props.contact.first_name,
    last_name: props.contact.last_name,
    entity_id: props.contact.entity_id,
    contact_function_id: props.contact.contact_function_id,
    email: props.contact.email,
    phone: props.contact.phone,
    mobile: props.contact.mobile,
    rgpd_consent: props.contact.rgpd_consent,
    notes: props.contact.notes,
    status: props.contact.status,
});

function submit() {
    form.put(route("contacts.update", props.contact.id));
}
</script>

<template>
    <AppLayout title="Edit Contact">
        <template #header>
            <h2
                class="text-3xl font-extrabold text-cyan-900 dark:text-cyan-100 tracking-tight mb-6"
            >
                Edit Contact
            </h2>
        </template>
        <form @submit.prevent="submit" class="max-w-2xl mx-auto space-y-8">
            <div
                class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6 items-start bg-white/80 dark:bg-slate-800/80 p-6 rounded-xl shadow"
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
                            v-if="form.errors.first_name"
                            class="text-sm text-red-600 mt-1"
                        >
                            {{ form.errors.first_name }}
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
                            v-if="form.errors.last_name"
                            class="text-sm text-red-600 mt-1"
                        >
                            {{ form.errors.last_name }}
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
                            v-if="form.errors.entity_id"
                            class="text-sm text-red-600 mt-1"
                        >
                            {{ form.errors.entity_id }}
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
                            v-if="form.errors.contact_function_id"
                            class="text-sm text-red-600 mt-1"
                        >
                            {{ form.errors.contact_function_id }}
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
                            v-if="form.errors.phone"
                            class="text-sm text-red-600 mt-1"
                        >
                            {{ form.errors.phone }}
                        </p>
                    </FormItem>
                </FormField>
                <FormField name="mobile">
                    <FormItem class="w-full">
                        <FormLabel>Mobile</FormLabel>
                        <FormControl>
                            <TextInput v-model="form.mobile" class="w-full" />
                        </FormControl>
                        <p
                            v-if="form.errors.mobile"
                            class="text-sm text-red-600 mt-1"
                        >
                            {{ form.errors.mobile }}
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
                            />
                        </FormControl>
                        <p
                            v-if="form.errors.email"
                            class="text-sm text-red-600 mt-1"
                        >
                            {{ form.errors.email }}
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
                            v-if="form.errors.status"
                            class="text-sm text-red-600 mt-1"
                        >
                            {{ form.errors.status }}
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
                            v-if="form.errors.notes"
                            class="text-sm text-red-600 mt-1"
                        >
                            {{ form.errors.notes }}
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
                            v-if="form.errors.rgpd_consent"
                            class="text-sm text-red-600 mt-1"
                        >
                            {{ form.errors.rgpd_consent }}
                        </p>
                    </FormItem>
                </FormField>
            </div>
            <div class="col-span-1 md:col-span-2 mt-8 flex justify-end">
                <button
                    type="submit"
                    class="inline-flex items-center gap-2 px-6 py-2 rounded-lg bg-cyan-700 text-white font-semibold shadow hover:bg-cyan-800 transition-all duration-150 focus:outline-none focus-visible:ring-2 focus-visible:ring-cyan-400"
                    :disabled="form.processing"
                >
                    {{ form.processing ? "Updating..." : "Update" }}
                </button>
            </div>
        </form>
    </AppLayout>
</template>
