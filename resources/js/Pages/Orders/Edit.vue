<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import TextInput from "@/Components/TextInput.vue";
import ArticleCombobox from "@/Components/ArticleCombobox.vue";
import { useForm } from "@inertiajs/vue3";
import { watch } from "vue";
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
    order: Object,
    clients: Array,
    articles: Array,
    suppliers: Array,
});

const form = useForm({
    date: props.order.date,
    client_id: props.order.client_id,
    valid_until: props.order.valid_until,
    status: props.order.status || "draft",
    lines: props.order.lines.map((line) => ({
        article_id: line.article_id,
        supplier_id: line.supplier_id || "",
        quantity: line.quantity,
        price: line.price,
        cost_price: line.cost_price ?? null,
    })),
});

watch(
    () => form.status,
    (val) => {
        if (val === "closed") {
            const today = new Date();
            form.date = today.toISOString().slice(0, 10);
            const validUntil = new Date(today);
            validUntil.setDate(validUntil.getDate() + 30);
            form.valid_until = validUntil.toISOString().slice(0, 10);
        }
    },
);

function convertToSupplierOrders() {
    if (confirm("Create supplier orders from this customer order?")) {
        form.post(route("orders.convertToSupplierOrders", props.order.id));
    }
}
function addLine() {
    form.lines.push({
        article_id: "",
        supplier_id: "",
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

function setArticlePrice(idx, articleId) {
    const article = props.articles.find((a) => a.id === articleId);
    if (article) {
        form.lines[idx].price = article.price;
    }
}

function formatArticleDisplay(article) {
    return article ? `${article.name} (${article.reference})` : "";
}

function submit() {
    form.put(route("orders.update", props.order.id));
}
</script>

<template>
    <AppLayout title="Edit Order">
        <template #header>
            <h2
                class="text-3xl font-extrabold text-cyan-900 dark:text-cyan-100 tracking-tight mb-6"
            >
                Edit Order
            </h2>
        </template>
        <form @submit.prevent="submit" class="max-w-3xl mx-auto space-y-8">
            <div
                class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6 items-start bg-white/80 dark:bg-slate-800/80 p-6 rounded-xl shadow"
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
                            <p
                                v-if="form.errors.date"
                                class="text-sm text-red-600 mt-1"
                            >
                                {{ form.errors.date }}
                            </p>
                        </FormItem>
                    </FormField>
                </div>
                <div class="flex flex-col gap-1 w-full">
                    <FormField name="client_id">
                        <FormItem class="w-full">
                            <FormLabel>Client</FormLabel>
                            <FormControl>
                                <div class="w-full relative">
                                    <Select v-model="form.client_id" required>
                                        <SelectTrigger class="w-full bg-white">
                                            <SelectValue
                                                placeholder="Selecionar Cliente"
                                            />
                                        </SelectTrigger>
                                        <SelectContent class="bg-white">
                                            <SelectItem
                                                v-for="client in clients"
                                                :key="client.id"
                                                :value="client.id"
                                            >
                                                {{ client.name }}
                                            </SelectItem>
                                        </SelectContent>
                                    </Select>
                                </div>
                            </FormControl>
                            <p
                                v-if="form.errors.client_id"
                                class="text-sm text-red-600 mt-1"
                            >
                                {{ form.errors.client_id }}
                            </p>
                        </FormItem>
                    </FormField>
                </div>
                <div class="flex flex-col gap-1 w-full">
                    <FormField name="valid_until">
                        <FormItem class="w-full">
                            <FormLabel>Valid Until</FormLabel>
                            <FormControl>
                                <TextInput
                                    v-model="form.valid_until"
                                    type="date"
                                    required
                                    class="w-full"
                                />
                            </FormControl>
                            <p
                                v-if="form.errors.valid_until"
                                class="text-sm text-red-600 mt-1"
                            >
                                {{ form.errors.valid_until }}
                            </p>
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
            <div class="mt-8">
                <h3 class="font-semibold mb-2">Order Lines</h3>
                <button
                    type="button"
                    @click="addLine"
                    class="mb-4 px-4 py-2 rounded-lg bg-green-600 text-white font-semibold shadow hover:bg-green-700 transition-all duration-150 focus:outline-none focus-visible:ring-2 focus-visible:ring-green-400"
                >
                    Add Line
                </button>
                <div
                    v-for="(line, idx) in form.lines"
                    :key="idx"
                    class="grid grid-cols-1 md:grid-cols-5 gap-2 mb-2 items-end bg-white/70 dark:bg-slate-700/70 p-2 rounded-lg"
                >
                    <div class="md:col-span-2">
                        <FormField :name="`lines.${idx}.article_id`">
                            <FormItem class="w-full">
                                <FormLabel>Article</FormLabel>
                                <FormControl>
                                    <ArticleCombobox
                                        :options="articles"
                                        :model-value="line.article_id"
                                        @update:model-value="
                                            (val) => {
                                                line.article_id = val;
                                                setArticlePrice(idx, val);
                                            }
                                        "
                                        placeholder="Search by name or reference..."
                                        labelField="name"
                                        valueField="id"
                                        :display-format="formatArticleDisplay"
                                    />
                                </FormControl>
                                <p
                                    v-if="
                                        form.errors[`lines.${idx}.article_id`]
                                    "
                                    class="text-sm text-red-600 mt-1"
                                >
                                    {{ form.errors[`lines.${idx}.article_id`] }}
                                </p>
                            </FormItem>
                        </FormField>
                    </div>
                    <div>
                        <FormField :name="`lines.${idx}.quantity`">
                            <FormItem class="w-full">
                                <FormLabel>Qty</FormLabel>
                                <FormControl>
                                    <TextInput
                                        v-model="line.quantity"
                                        type="number"
                                        min="1"
                                        required
                                        class="w-full"
                                    />
                                </FormControl>
                                <p
                                    v-if="form.errors[`lines.${idx}.quantity`]"
                                    class="text-sm text-red-600 mt-1"
                                >
                                    {{ form.errors[`lines.${idx}.quantity`] }}
                                </p>
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
                                <p
                                    v-if="form.errors[`lines.${idx}.price`]"
                                    class="text-sm text-red-600 mt-1"
                                >
                                    {{ form.errors[`lines.${idx}.price`] }}
                                </p>
                            </FormItem>
                        </FormField>
                    </div>
                    <div>
                        <FormField :name="`lines.${idx}.supplier_id`">
                            <FormItem class="w-full">
                                <FormLabel>Supplier</FormLabel>
                                <FormControl>
                                    <Select v-model="line.supplier_id">
                                        <SelectTrigger class="w-full bg-white">
                                            <SelectValue
                                                placeholder="Select Supplier (optional)"
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
                    <div>
                        <button
                            type="button"
                            @click="removeLine(idx)"
                            class="px-2 py-1 rounded bg-red-600 text-white font-semibold shadow hover:bg-red-700 transition-all duration-150 focus:outline-none focus-visible:ring-2 focus-visible:ring-red-400"
                        >
                            Remove
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-span-1 md:col-span-2 mt-8 flex justify-between">
                <template v-if="form.status === 'closed'">
                    <button
                        type="button"
                        class="inline-flex items-center gap-2 px-6 py-2 rounded-lg bg-yellow-600 text-white font-semibold shadow hover:bg-yellow-700 transition-all duration-150 focus:outline-none focus-visible:ring-2 focus-visible:ring-yellow-400"
                        @click="convertToSupplierOrders"
                    >
                        Convert to Supplier Orders
                    </button>
                </template>
                <button
                    type="submit"
                    class="inline-flex items-center gap-2 px-6 py-2 rounded-lg bg-cyan-700 text-white font-semibold shadow hover:bg-cyan-800 transition-all duration-150 focus:outline-none focus-visible:ring-2 focus-visible:ring-cyan-400"
                    :disabled="form.processing"
                >
                    {{ form.processing ? "Saving..." : "Save" }}
                </button>
            </div>
        </form>
    </AppLayout>
</template>
