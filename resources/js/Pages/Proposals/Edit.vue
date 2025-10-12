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
import ArticleCombobox from "@/Components/ArticleCombobox.vue";
import TextInput from "@/Components/TextInput.vue";
import { watch } from "vue";

const props = defineProps({
    proposal: Object,
    clients: Array,
    articles: Array,
    suppliers: Array,
});

const { errors } = usePage().props;

const form = useForm({
    date: props.proposal.date,
    client_id: props.proposal.client_id,
    valid_until: props.proposal.valid_until,
    status: props.proposal.status || "draft",
    lines: props.proposal.lines.map((line) => ({
        article_id: line.article_id,
        supplier_id: line.supplier_id || "",
        quantity: line.quantity,
        price: line.price,
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
function setArticlePrice(idx, articleId) {
    const article = props.articles.find((a) => a.id === articleId);
    if (article) {
        form.lines[idx].price = article.price;
    }
}

function addLine() {
    form.lines.push({
        article_id: "",
        supplier_id: "",
        quantity: 1,
        price: 0,
    });
}

function removeLine(idx) {
    form.lines.splice(idx, 1);
}

function formatArticleDisplay(article) {
    return article ? `${article.name} (${article.reference})` : "";
}

function submit() {
    form.put(route("proposals.update", props.proposal.id));
}

function convertToOrder() {
    if (
        confirm(
            "Are you sure you want to convert this proposal into an order?",
        )
    ) {
        form.post(route("proposals.convertToOrder", props.proposal.id));
    }
}
</script>

<template>
    <AppLayout title="Edit Proposal">
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                Edit Proposal
            </h2>
        </template>
        <div class="py-6 max-w-3xl mx-auto">
            <form @submit.prevent="submit">
                <div
                    v-if="form.errors.error || errors.error"
                    class="text-red-500 mb-4"
                >
                    <div v-if="errors.error">{{ errors.error }}</div>
                    <div v-if="form.errors.error">{{ form.errors.error }}</div>
                </div>
                <div
                    class="grid grid-cols-1 md:grid-cols-3 gap-x-8 gap-y-4 items-start"
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
                                        <Select v-model="form.client_id">
                                            <SelectTrigger
                                                class="w-full bg-white"
                                            >
                                                <SelectValue
                                                    placeholder="Select Client"
                                                />
                                            </SelectTrigger>
                                            <SelectContent class="bg-white">
                                                <SelectItem
                                                    v-for="client in props.clients"
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
                    <h3 class="font-semibold mb-2">Proposal Lines</h3>
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
                        class="grid grid-cols-1 md:grid-cols-5 gap-2 mb-2 items-end"
                    >
                        <div class="md:col-span-2">
                            <FormField :name="`lines.${idx}.article_id`">
                                <FormItem class="w-full">
                                    <FormLabel>Article</FormLabel>
                                    <FormControl>
                                        <ArticleCombobox
                                            :options="props.articles"
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
                                            :display-format="
                                                formatArticleDisplay
                                            "
                                        />
                                    </FormControl>
                                    <p
                                        v-if="
                                            form.errors[
                                                `lines.${idx}.article_id`
                                            ]
                                        "
                                        class="text-sm text-red-600 mt-1"
                                    >
                                        {{
                                            form.errors[
                                                `lines.${idx}.article_id`
                                            ]
                                        }}
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
                                        v-if="
                                            form.errors[`lines.${idx}.quantity`]
                                        "
                                        class="text-sm text-red-600 mt-1"
                                    >
                                        {{
                                            form.errors[`lines.${idx}.quantity`]
                                        }}
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
                                            v-model="line.price"
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
                                            <SelectTrigger
                                                class="w-full bg-white"
                                            >
                                                <SelectValue
                                                    placeholder="Select Supplier (optional)"
                                                />
                                            </SelectTrigger>
                                            <SelectContent class="bg-white">
                                                <SelectItem
                                                    v-for="supplier in props.suppliers"
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
                                class="px-2 py-1 bg-red-600 text-white rounded hover:bg-red-700"
                            >
                                Remove
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-span-1 md:col-span-2 mt-8 flex justify-between">
                    <button
                        type="button"
                        class="px-6 py-2 bg-yellow-600 text-white rounded hover:bg-yellow-700 transition"
                        @click="convertToOrder"
                    >
                        Converte to Order
                    </button>
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
