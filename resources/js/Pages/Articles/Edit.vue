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
    article: Object,
    vatRates: Array,
});

const form = useForm({
    name: props.article.name,
    reference: props.article.reference,
    description: props.article.description,
    price: props.article.price,
    vat_rate_id: props.article.vat_rate_id,
    status: props.article.status,
});

function submit() {
    form.put(route("articles.update", props.article.id));
}
</script>

<template>
    <AppLayout title="Edit Article">
        <template #header>
            <h2
                class="text-3xl font-extrabold text-cyan-900 dark:text-cyan-100 tracking-tight mb-6"
            >
                Edit Article
            </h2>
        </template>
        <div class="py-6 max-w-3xl mx-auto">
            <form @submit.prevent="submit" class="space-y-8">
                <div v-if="backendErrors.error" class="text-red-500 mb-4">
                    {{ backendErrors.error }}
                </div>
                <div
                    class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6 items-start bg-white/80 dark:bg-slate-800/80 p-6 rounded-xl shadow"
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
                                    v-if="
                                        form.errors.reference ||
                                        backendErrors.reference
                                    "
                                    class="text-sm text-red-600 mt-1"
                                >
                                    {{
                                        form.errors.reference ||
                                        backendErrors.reference
                                    }}
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
                                    v-if="
                                        form.errors.description ||
                                        backendErrors.description
                                    "
                                    class="text-sm text-red-600 mt-1"
                                >
                                    {{
                                        form.errors.description ||
                                        backendErrors.description
                                    }}
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
                                    v-if="
                                        form.errors.price || backendErrors.price
                                    "
                                    class="text-sm text-red-600 mt-1"
                                >
                                    {{
                                        form.errors.price || backendErrors.price
                                    }}
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
                                    v-if="
                                        form.errors.vat_rate_id ||
                                        backendErrors.vat_rate_id
                                    "
                                    class="text-sm text-red-600 mt-1"
                                >
                                    {{
                                        form.errors.vat_rate_id ||
                                        backendErrors.vat_rate_id
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
                </div>
                <div class="col-span-1 md:col-span-2 mt-8 flex justify-end">
                    <button
                        type="submit"
                        class="inline-flex items-center gap-2 px-6 py-2 rounded-lg bg-cyan-700 text-white font-semibold shadow hover:bg-cyan-800 transition-all duration-150 focus:outline-none focus-visible:ring-2 focus-visible:ring-cyan-400"
                        :disabled="form.processing"
                    >
                        {{ form.processing ? "Saving..." : "Save" }}
                    </button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
