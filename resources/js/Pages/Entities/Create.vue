<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { ref, onMounted, watch } from "vue";
import {
    Form,
    FormField,
    FormItem,
    FormLabel,
    FormControl,
    FormMessage,
} from "@/Components/ui/form";
import {
    Select,
    SelectItem,
    SelectContent,
    SelectTrigger,
    SelectValue,
} from "@/Components/ui/select";
import TextInput from "@/Components/TextInput.vue";
import { useForm } from "vee-validate";
import { router } from "@inertiajs/vue3";

const props = defineProps({
    countries: Array,
    type: String,
});

// Refs para selects controlados
const typeRef = ref(props.type || "client");
const countryIdRef = ref(
    props.countries && props.countries.length > 0 ? props.countries[0].id : "",
);

// Initialize with empty name to prevent flashing
const form = useForm({
    type: typeRef.value,
    number: "",
    nif: "",
    name: "",
    address: "",
    postal_code: "",
    city: "",
    country_id: countryIdRef.value,
    phone: "",
    mobile: "",
    website: "",
    email: "",
    rgpd_consent: false,
    notes: "",
    status: "active",
});

// Watch for prop changes and update form.type and country_id accordingly
// Sincronizar refs com form do vee-validate
watch(typeRef, (val) => {
    form.type = val;
});
watch(countryIdRef, (val) => {
    form.country_id = val;
});
// Se props mudarem, atualizar refs
watch(
    () => props.type,
    (newType) => {
        if (newType && typeRef.value !== newType) {
            typeRef.value = newType;
        }
    },
    { immediate: true },
);
watch(
    () => props.countries,
    (newCountries) => {
        if (
            Array.isArray(newCountries) &&
            newCountries.length > 0 &&
            !countryIdRef.value
        ) {
            countryIdRef.value = newCountries[0].id;
        }
    },
    { immediate: true },
);

const loadingVies = ref(false);
const viesError = ref("");
const nameInput = ref(null);

async function lookupVIES() {
    viesError.value = "";
    if (!form.nif || !form.country_id) return;
    loadingVies.value = true;
    try {
        const country = props.countries.find((c) => c.id == form.country_id);
        if (!country) return;
        const response = await fetch("/entities/vies-lookup", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector("meta[name=csrf-token]")
                    .content,
            },
            body: JSON.stringify({
                country_code: country.code,
                vat_number: form.nif,
            }),
        });
        const data = await response.json();
        if (data.valid) {
            form.name = data.name;
            form.address = data.address;
        } else {
            viesError.value = "NIF not found or not valid in VIES.";
        }
    } catch (e) {
        viesError.value = "VIES service unavailable.";
    } finally {
        loadingVies.value = false;
    }
}

function submit() {
    router.post(route("entities.store"), form);
}

onMounted(() => {
    // Ensure name is empty on mount
    form.name = "";
    // Clear any potential browser autofill immediately
    if (nameInput.value) {
        const input = nameInput.value.$el || nameInput.value;
        if (input) {
            input.value = "";
        }
    }
});
</script>
<template>
    <AppLayout title="Create Entity">
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                Create Entity
            </h2>
        </template>
        <div class="py-6 max-w-3xl mx-auto">
            <Form @submit.prevent="submit">
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
                            </FormItem>
                        </FormField>
                    </div>
                    <div class="flex flex-col gap-1 w-full">
                        <FormField name="number">
                            <FormItem class="w-full">
                                <FormLabel>Number</FormLabel>
                                <FormControl>
                                    <TextInput
                                        v-model="form.number"
                                        type="number"
                                        required
                                        class="w-full"
                                    />
                                </FormControl>
                            </FormItem>
                        </FormField>
                    </div>
                    <div class="flex flex-col gap-1 w-full">
                        <FormField name="nif">
                            <FormItem class="w-full">
                                <FormLabel>NIF</FormLabel>
                                <FormControl>
                                    <div class="flex gap-2 items-center w-full">
                                        <TextInput
                                            v-model="form.nif"
                                            @blur="lookupVIES"
                                            required
                                            class="w-full"
                                        />
                                        <button
                                            type="button"
                                            @click="lookupVIES"
                                            :disabled="loadingVies"
                                            class="px-2 py-1 bg-gray-200 rounded text-xs flex items-center justify-center min-w-14"
                                        >
                                            <span v-if="!loadingVies"
                                                >VIES</span
                                            >
                                            <span v-else>...</span>
                                        </button>
                                    </div>
                                </FormControl>
                                <FormMessage v-if="viesError">{{
                                    viesError
                                }}</FormMessage>
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
                                        autocomplete="off"
                                        data-form-type="other"
                                        name="_company_name_field"
                                        ref="nameInput"
                                        value=""
                                    />
                                </FormControl>
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
                            </FormItem>
                        </FormField>
                    </div>
                </div>
                <div class="col-span-1 md:col-span-2 mt-8 flex justify-end">
                    <button
                        type="submit"
                        class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition"
                    >
                        Create
                    </button>
                </div>
            </Form>
        </div>
    </AppLayout>
</template>
