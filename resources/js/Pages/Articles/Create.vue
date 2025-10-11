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

const props = defineProps({
    vatRates: Array,
});

const form = useForm({
    name: "",
    reference: "",
    description: "",
    price: "",
    vat_rate_id:
        props.vatRates && props.vatRates.length > 0 ? props.vatRates[0].id : "",
    status: "active",
});

function submit() {
    form.post(route("articles.store"));
    
}
</script>

<template>
    <AppLayout title="Create Article">
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                Create Article
            </h2>
        </template>
        <div class="py-6 max-w-3xl mx-auto">
            <form @submit.prevent="submit">
                <div
                    v-if="form.errors.error || errors.error"
                    class="text-red-500"
                >
                    <div v-if="errors.error">{{ errors.error }}</div>
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
                                    v-if="form.errors.name"
                                    class="text-sm text-red-600 mt-1"
                                >
                                    {{ form.errors.name }}
                                </p>
                            </FormItem>
                        </FormField>
                    </div>
                    <div class="flex flex-col gap-1 w-full">
                        <FormField name="reference">
                            <FormItem class="w-full">
                                <FormLabel>Reference</FormLabel>
                                <FormControl>
                                    <TextInput
                                        v-model="form.reference"
                                        required
                                        class="w-full"
                                    />
                                </FormControl>
                                <p
                                    v-if="form.errors.reference"
                                    class="text-sm text-red-600 mt-1"
                                >
                                    {{ form.errors.reference }}
                                </p>
                            </FormItem>
                        </FormField>
                    </div>
                    <div class="flex flex-col gap-1 w-full md:col-span-2">
                        <FormField name="description">
                            <FormItem class="w-full">
                                <FormLabel>Description</FormLabel>
                                <FormControl>
                                    <textarea
                                        v-model="form.description"
                                        class="w-full border rounded min-h-[80px]"
                                    />
                                </FormControl>
                                <p
                                    v-if="form.errors.description"
                                    class="text-sm text-red-600 mt-1"
                                >
                                    {{ form.errors.description }}
                                </p>
                            </FormItem>
                        </FormField>
                    </div>
                    <div class="flex flex-col gap-1 w-full">
                        <FormField name="price">
                            <FormItem class="w-full">
                                <FormLabel>Price</FormLabel>
                                <FormControl>
                                    <TextInput
                                        v-model="form.price"
                                        type="number"
                                        step="0.01"
                                        required
                                        class="w-full"
                                    />
                                </FormControl>
                                <p
                                    v-if="form.errors.price"
                                    class="text-sm text-red-600 mt-1"
                                >
                                    {{ form.errors.price }}
                                </p>
                            </FormItem>
                        </FormField>
                    </div>
                    <div class="flex flex-col gap-1 w-full">
                        <FormField name="vat_rate_id">
                            <FormItem class="w-full">
                                <FormLabel>VAT Rate</FormLabel>
                                <FormControl>
                                    <div class="w-full relative">
                                        <Select v-model="form.vat_rate_id">
                                            <SelectTrigger
                                                class="w-full bg-white"
                                            >
                                                <SelectValue
                                                    placeholder="Select VAT Rate"
                                                />
                                            </SelectTrigger>
                                            <SelectContent class="bg-white">
                                                <SelectItem
                                                    v-for="vat in props.vatRates"
                                                    :key="vat.id"
                                                    :value="vat.id"
                                                >
                                                    {{ vat.name }} ({{
                                                        vat.rate
                                                    }}%)
                                                </SelectItem>
                                            </SelectContent>
                                        </Select>
                                    </div>
                                </FormControl>
                                <p
                                    v-if="form.errors.vat_rate_id"
                                    class="text-sm text-red-600 mt-1"
                                >
                                    {{ form.errors.vat_rate_id }}
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
        </div>
    </AppLayout>
</template>
