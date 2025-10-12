<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import TextInput from "@/Components/TextInput.vue";
import ArticleCombobox from "@/Components/ArticleCombobox.vue";
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
import { useForm, usePage } from "@inertiajs/vue3";

const page = usePage();
const backendErrors = page.props.errors || {};

const props = defineProps({
    clients: Array,
    articles: Array,
    suppliers: Array,
});

const { clients, articles, suppliers } = props;

const form = useForm({
    date: new Date().toISOString().slice(0, 10),
    client_id: "",
    valid_until: new Date(Date.now() + 30 * 24 * 60 * 60 * 1000)
        .toISOString()
        .slice(0, 10),
    status: "draft",
    lines: [
        {
            article_id: "",
            supplier_id: "",
            quantity: 1,
            price: 0,
            cost_price: null,
        },
    ],
});

function addLine() {
    form.lines.push({
        article_id: "",
        supplier_id: "",
        quantity: 1,
        price: 0,
        cost_price: null,
    });
}

function removeLine(idx) {
    form.lines.splice(idx, 1);
}

function setArticlePrice(idx, articleId) {
    const article = articles.find((a) => a.id === articleId);
    if (article) {
        form.lines[idx].price = article.price;
    }
}

function formatArticleDisplay(article) {
    return article ? `${article.name} (${article.reference})` : "";
}

function submit() {
    form.post(route("orders.store"));
}
</script>

<template>
    <AppLayout title="Create Order">
        <form @submit.prevent="submit" class="max-w-2xl mx-auto space-y-4">
            <div
                class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4 items-start"
            >
                <FormField name="date">
                    <FormItem class="w-full">
                        <FormLabel>Data</FormLabel>
                        <FormControl>
                            <TextInput
                                v-model="form.date"
                                type="date"
                                required
                                class="w-full"
                            />
                        </FormControl>
                        <p
                            v-if="form.errors.date || backendErrors.date"
                            class="text-sm text-red-600 mt-1"
                        >
                            {{ form.errors.date || backendErrors.date }}
                        </p>
                    </FormItem>
                </FormField>
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
                            v-if="
                                form.errors.client_id || backendErrors.client_id
                            "
                            class="text-sm text-red-600 mt-1"
                        >
                            {{
                                form.errors.client_id || backendErrors.client_id
                            }}
                        </p>
                    </FormItem>
                </FormField>
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
                            v-if="
                                form.errors.valid_until ||
                                backendErrors.valid_until
                            "
                            class="text-sm text-red-600 mt-1"
                        >
                            {{
                                form.errors.valid_until ||
                                backendErrors.valid_until
                            }}
                        </p>
                    </FormItem>
                </FormField>
                <FormField name="status">
                    <FormItem class="w-full">
                        <FormLabel>Status</FormLabel>
                        <FormControl>
                            <Select v-model="form.status">
                                <SelectTrigger class="w-full bg-white">
                                    <SelectValue placeholder="Select Status" />
                                </SelectTrigger>
                                <SelectContent class="bg-white">
                                    <SelectItem value="draft">Draft</SelectItem>
                                    <SelectItem value="closed"
                                        >Closed</SelectItem
                                    >
                                </SelectContent>
                            </Select>
                        </FormControl>
                        <p
                            v-if="form.errors.status || backendErrors.status"
                            class="text-sm text-red-600 mt-1"
                        >
                            {{ form.errors.status || backendErrors.status }}
                        </p>
                    </FormItem>
                </FormField>
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
                    class="grid grid-cols-1 md:grid-cols-5 gap-2 mb-2 items-end"
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
                                        form.errors[
                                            `lines.${idx}.article_id`
                                        ] ||
                                        backendErrors[`lines.${idx}.article_id`]
                                    "
                                    class="text-sm text-red-600 mt-1"
                                >
                                    {{
                                        form.errors[
                                            `lines.${idx}.article_id`
                                        ] ||
                                        backendErrors[`lines.${idx}.article_id`]
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
                                        form.errors[`lines.${idx}.quantity`] ||
                                        backendErrors[`lines.${idx}.quantity`]
                                    "
                                    class="text-sm text-red-600 mt-1"
                                >
                                    {{
                                        form.errors[`lines.${idx}.quantity`] ||
                                        backendErrors[`lines.${idx}.quantity`]
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
                                    v-if="
                                        form.errors[`lines.${idx}.price`] ||
                                        backendErrors[`lines.${idx}.price`]
                                    "
                                    class="text-sm text-red-600 mt-1"
                                >
                                    {{
                                        form.errors[`lines.${idx}.price`] ||
                                        backendErrors[`lines.${idx}.price`]
                                    }}
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
                            class="px-2 py-1 bg-red-600 text-white rounded hover:bg-red-700"
                        >
                            Remove
                        </button>
                    </div>
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
    </AppLayout>
</template>
