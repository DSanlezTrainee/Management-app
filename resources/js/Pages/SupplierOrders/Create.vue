<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { useForm } from "@inertiajs/vue3";
import TextInput from "@/Components/TextInput.vue";
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
import ArticleCombobox from "@/Components/ArticleCombobox.vue";

const props = defineProps({ suppliers: Array, articles: Array });

const form = useForm({
    date: "",
    supplier_id: "",
    valid_until: "",
    status: "draft",
    lines: [{ article_id: "", quantity: 1, price: 0, cost_price: null }],
});

function addLine() {
    form.lines.push({
        article_id: "",
        quantity: 1,
        price: 0,
        cost_price: null,
    });
}

function getLinePrice(line) {
    const article = props.articles.find((a) => a.id == line.article_id);
    const q = Number(line.quantity);
    const p = article ? Number(article.price) : 0;
    if (isNaN(q) || isNaN(p)) return "0.00";
    return (q * p).toFixed(2);
}

function removeLine(idx) {
    form.lines.splice(idx, 1);
}
function submit() {
    form.post(route("supplier-orders.store"));
}
</script>
<template>
    <AppLayout title="Nova Encomenda de Fornecedor">
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                New Supplier Order
            </h2>
        </template>
        <form @submit.prevent="submit" class="max-w-3xl mx-auto space-y-4">
            <div
                class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4 items-start"
            >
                <div class="flex flex-col gap-1 w-full">
                    <FormField name="date">
                        <FormItem class="w-full">
                            <FormLabel>Date</FormLabel>
                            <FormControl>
                                <TextInput
                                    v-model="form.date"
                                    type="date"
                                    required
                                    class="w-full"
                                />
                            </FormControl>
                        </FormItem>
                    </FormField>
                </div>
                <div class="flex flex-col gap-1 w-full">
                    <FormField name="supplier_id">
                        <FormItem class="w-full">
                            <FormLabel>Supplier</FormLabel>
                            <FormControl>
                                <Select v-model="form.supplier_id">
                                    <SelectTrigger class="w-full bg-white">
                                        <SelectValue
                                            placeholder="Select Supplier"
                                        />
                                    </SelectTrigger>
                                    <SelectContent class="bg-white">
                                        <SelectItem
                                            v-for="supplier in suppliers"
                                            :key="supplier.id"
                                            :value="supplier.id"
                                        >
                                            {{ supplier.name }}
                                        </SelectItem>
                                    </SelectContent>
                                </Select>
                            </FormControl>
                        </FormItem>
                    </FormField>
                </div>
                <div class="flex flex-col gap-1 w-full">
                    <FormField name="valid_until">
                        <FormItem class="w-full">
                            <FormLabel>Validity</FormLabel>
                            <FormControl>
                                <TextInput
                                    v-model="form.valid_until"
                                    type="date"
                                    class="w-full"
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
                                <Select v-model="form.status">
                                    <SelectTrigger class="w-full bg-white">
                                        <SelectValue
                                            placeholder="Select Status"
                                        />
                                    </SelectTrigger>
                                    <SelectContent class="bg-white">
                                        <SelectItem value="draft"
                                            >Draft</SelectItem
                                        >
                                        <SelectItem value="closed"
                                            >Closed</SelectItem
                                        >
                                    </SelectContent>
                                </Select>
                            </FormControl>
                        </FormItem>
                    </FormField>
                </div>
            </div>
            <div class="mt-8">
                <h3 class="font-semibold mb-2">Order Lines</h3>
                <button
                    type="button"
                    @click="addLine"
                    class="mb-4 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700"
                >
                    Add Line
                </button>
                <div
                    v-for="(line, idx) in form.lines"
                    :key="idx"
                    class="grid grid-cols-1 md:grid-cols-4 gap-2 mb-2 items-end"
                >
                    <div>
                        <FormField :name="`lines.${idx}.article_id`">
                            <FormItem class="w-full">
                                <FormLabel>Article</FormLabel>
                                <FormControl>
                                    <ArticleCombobox
                                        v-model="line.article_id"
                                        :options="articles"
                                        labelField="name"
                                        valueField="id"
                                        placeholder="Select Article"
                                    />
                                </FormControl>
                            </FormItem>
                        </FormField>
                    </div>
                    <div>
                        <FormField :name="`lines.${idx}.quantity`">
                            <FormItem class="w-full">
                                <FormLabel>Quantity</FormLabel>
                                <FormControl>
                                    <TextInput
                                        v-model="line.quantity"
                                        type="number"
                                        min="1"
                                        required
                                        class="w-full"
                                    />
                                </FormControl>
                            </FormItem>
                        </FormField>
                    </div>
                    <div>
                        <FormField :name="`lines.${idx}.price`">
                            <FormItem class="w-full">
                                <FormLabel>Price</FormLabel>
                                <FormControl>
                                    <TextInput
                                        :value="getLinePrice(line)"
                                        type="number"
                                        min="0"
                                        step="0.01"
                                        required
                                        class="w-full"
                                    />
                                </FormControl>
                            </FormItem>
                        </FormField>
                    </div>
                    <div>
                        <button
                            type="button"
                            @click="removeLine(idx)"
                            class="px-2 py-1 bg-red-600 text-white rounded hover:bg-red-700"
                        >
                            Remove
                        </button>
                    </div>
                </div>
            </div>
            <div class="mt-8 flex justify-end">
                <button
                    type="submit"
                    class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition"
                    :disabled="form.processing"
                >
                    {{ form.processing ? "Saving..." : "Save" }}
                </button>
            </div>
        </form>
    </AppLayout>
</template>
