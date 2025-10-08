<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { ref, watch } from "vue";
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
import { useForm, router, usePage } from "@inertiajs/vue3";

const page = usePage();
const backendErrors = page.props.errors || {};

const props = defineProps({
    entity: Object,
    countries: Array,
});

const typeRef = ref(props.entity.type);
const countryIdRef = ref(props.entity.country_id);

const form = useForm({
    type: props.entity.type,
    number: props.entity.number,
    nif: props.entity.nif,
    name: props.entity.name,
    address: props.entity.address,
    postal_code: props.entity.postal_code,
    city: props.entity.city,
    country_id: props.entity.country_id,
    phone: props.entity.phone,
    mobile: props.entity.mobile,
    website: props.entity.website,
    email: props.entity.email,
    rgpd_consent: props.entity.rgpd_consent,
    notes: props.entity.notes,
    status: props.entity.status,
});

watch(typeRef, (val) => {
    form.type = val;
});
watch(countryIdRef, (val) => {
    form.country_id = val;
});

function submit() {
    form.put(route("entities.update", props.entity.id), {
        onSuccess: () => {
            console.log("Form submitted successfully!");
        },
        onError: (errors) => {
            console.log("Form submission errors:", errors);
        },
    });
}
</script>
<template>
    <AppLayout title="Edit Entity">
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                Edit Entity
            </h2>
        </template>
        <div class="py-6 max-w-3xl mx-auto">
            <form @submit.prevent="submit">
                <div
                    class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4 items-start"
                >
                    <div class="flex flex-col gap-1 w-full">
                        <FormField name="type">
                            <FormItem class="w-full">
                                <FormLabel>Type</FormLabel>
                                <FormControl>
                                    <div class="w-full relative">
                                        <Select v-model="typeRef">
                                            <SelectTrigger
                                                class="w-full bg-white"
                                            >
                                                <SelectValue
                                                    placeholder="Select a type"
                                                />
                                            </SelectTrigger>
                                            <SelectContent class="bg-white">
                                                <SelectItem value="client"
                                                    >Client</SelectItem
                                                >
                                                <SelectItem value="supplier"
                                                    >Supplier</SelectItem
                                                >
                                                <SelectItem value="both"
                                                    >Client and
                                                    Supplier</SelectItem
                                                >
                                            </SelectContent>
                                        </Select>
                                    </div>
                                </FormControl>
                                <p
                                    v-if="
                                        form.errors.type || backendErrors.type
                                    "
                                    class="text-sm text-red-600 mt-1"
                                >
                                    {{ form.errors.type || backendErrors.type }}
                                </p>
                            </FormItem>
                        </FormField>
                    </div>
                    <div class="flex flex-col gap-1 w-full">
                        <FormField name="nif">
                            <FormItem class="w-full">
                                <FormLabel>NIF</FormLabel>
                                <FormControl>
                                    <TextInput
                                        v-model="form.nif"
                                        required
                                        class="w-full"
                                    />
                                </FormControl>
                                <p
                                    v-if="form.errors.nif || backendErrors.nif"
                                    class="text-sm text-red-600 mt-1"
                                >
                                    {{ form.errors.nif || backendErrors.nif }}
                                </p>
                            </FormItem>
                        </FormField>
                    </div>
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
                        <FormField name="address">
                            <FormItem class="w-full">
                                <FormLabel>Address</FormLabel>
                                <FormControl>
                                    <TextInput
                                        v-model="form.address"
                                        class="w-full"
                                    />
                                </FormControl>
                                <p
                                    v-if="
                                        form.errors.address ||
                                        backendErrors.address
                                    "
                                    class="text-sm text-red-600 mt-1"
                                >
                                    {{
                                        form.errors.address ||
                                        backendErrors.address
                                    }}
                                </p>
                            </FormItem>
                        </FormField>
                    </div>
                    <div class="flex flex-col gap-1 w-full">
                        <FormField name="postal_code">
                            <FormItem class="w-full">
                                <FormLabel>Postal Code</FormLabel>
                                <FormControl>
                                    <TextInput
                                        v-model="form.postal_code"
                                        placeholder="1234-567"
                                        class="w-full"
                                    />
                                </FormControl>
                                <p
                                    v-if="
                                        form.errors.postal_code ||
                                        backendErrors.postal_code
                                    "
                                    class="text-sm text-red-600 mt-1"
                                >
                                    {{
                                        form.errors.postal_code ||
                                        backendErrors.postal_code
                                    }}
                                </p>
                            </FormItem>
                        </FormField>
                    </div>
                    <div class="flex flex-col gap-1 w-full">
                        <FormField name="city">
                            <FormItem class="w-full">
                                <FormLabel>City</FormLabel>
                                <FormControl>
                                    <TextInput
                                        v-model="form.city"
                                        class="w-full"
                                    />
                                </FormControl>
                                <p
                                    v-if="
                                        form.errors.city || backendErrors.city
                                    "
                                    class="text-sm text-red-600 mt-1"
                                >
                                    {{ form.errors.city || backendErrors.city }}
                                </p>
                            </FormItem>
                        </FormField>
                    </div>
                    <div class="flex flex-col gap-1 w-full">
                        <FormField name="country_id">
                            <FormItem class="w-full">
                                <FormLabel>Country</FormLabel>
                                <FormControl>
                                    <div class="w-full relative">
                                        <Select v-model="countryIdRef">
                                            <SelectTrigger
                                                class="w-full bg-white"
                                            >
                                                <SelectValue
                                                    placeholder="Select a country"
                                                />
                                            </SelectTrigger>
                                            <SelectContent class="bg-white">
                                                <SelectItem
                                                    v-for="country in props.countries"
                                                    :key="country.id"
                                                    :value="country.id"
                                                >
                                                    {{ country.name }}
                                                </SelectItem>
                                            </SelectContent>
                                        </Select>
                                    </div>
                                </FormControl>
                                <p
                                    v-if="
                                        form.errors.country_id ||
                                        backendErrors.country_id
                                    "
                                    class="text-sm text-red-600 mt-1"
                                >
                                    {{
                                        form.errors.country_id ||
                                        backendErrors.country_id
                                    }}
                                </p>
                            </FormItem>
                        </FormField>
                    </div>
                    <div class="flex flex-col gap-1 w-full">
                        <FormField name="phone">
                            <FormItem class="w-full">
                                <FormLabel>Phone</FormLabel>
                                <FormControl>
                                    <TextInput
                                        v-model="form.phone"
                                        class="w-full"
                                    />
                                </FormControl>
                                <p
                                    v-if="
                                        form.errors.phone || backendErrors.phone
                                    "
                                    class="text-sm text-red-600 mt-1"
                                >
                                    {{
                                        form.errors.phone || backendErrors.phone
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
                        <FormField name="website">
                            <FormItem class="w-full">
                                <FormLabel>Website</FormLabel>
                                <FormControl>
                                    <TextInput
                                        v-model="form.website"
                                        class="w-full"
                                    />
                                </FormControl>
                                <p
                                    v-if="
                                        form.errors.website ||
                                        backendErrors.website
                                    "
                                    class="text-sm text-red-600 mt-1"
                                >
                                    {{
                                        form.errors.website ||
                                        backendErrors.website
                                    }}
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
                        <FormField name="rgpd_consent">
                            <FormItem class="w-full flex items-center gap-2">
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
