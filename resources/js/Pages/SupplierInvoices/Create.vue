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
import { computed, watch } from "vue";
import { ref } from "vue";
const showPaymentAlert = computed(() => form.status === "paid");

const props = defineProps({
    suppliers: Array,
    supplierOrders: Array,
});

const form = useForm({
    invoice_date: "",
    due_date: "",
    supplier_id: "",
    supplier_order_id: "",
    total: "",
    document: null,
    payment_receipt: null,
    status: "pending",
});

const filteredSupplierOrders = computed(() => {
    if (!form.supplier_id) return [];
    return props.supplierOrders.filter(
        (order) => order.supplier_id == form.supplier_id,
    );
});

watch(
    () => form.supplier_order_id,
    (newOrderId) => {
        if (!newOrderId) return;
        const order = props.supplierOrders.find((o) => o.id == newOrderId);
        if (order && order.total !== undefined) {
            form.total = order.total;
        }
    },
);

function submit() {
    form.post(route("supplier-invoices.store"), {
        forceFormData: true,
    });
}

console.log("suppliers", props.suppliers);
console.log("supplierOrders", props.supplierOrders);
</script>

<template>
    <AppLayout title="New Supplier Invoice">
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                New Supplier Invoice
            </h2>
        </template>
        <form @submit.prevent="submit" class="max-w-3xl mx-auto space-y-4">
            <div
                class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4 items-start"
            >
                <div class="flex flex-col gap-1 w-full">
                    <FormField name="invoice_date">
                        <FormItem class="w-full">
                            <FormLabel>Invoice Date</FormLabel>
                            <FormControl>
                                <TextInput
                                    v-model="form.invoice_date"
                                    type="date"
                                    required
                                    class="w-full"
                                />
                            </FormControl>
                        </FormItem>
                    </FormField>
                </div>
                <div class="flex flex-col gap-1 w-full">
                    <FormField name="due_date">
                        <FormItem class="w-full">
                            <FormLabel>Due Date</FormLabel>
                            <FormControl>
                                <TextInput
                                    v-model="form.due_date"
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
                    <FormField name="supplier_order_id">
                        <FormItem class="w-full">
                            <FormLabel>Supplier Order</FormLabel>
                            <FormControl>
                                <Select v-model="form.supplier_order_id">
                                    <SelectTrigger class="w-full bg-white">
                                        <SelectValue
                                            placeholder="Select Order"
                                        />
                                    </SelectTrigger>
                                    <SelectContent class="bg-white">
                                        <SelectItem
                                            v-for="order in filteredSupplierOrders"
                                            :key="order.id"
                                            :value="order.id"
                                        >
                                            {{ order.number }}
                                        </SelectItem>
                                    </SelectContent>
                                </Select>
                            </FormControl>
                        </FormItem>
                    </FormField>
                </div>
                <div class="flex flex-col gap-1 w-full">
                    <FormField name="total">
                        <FormItem class="w-full">
                            <FormLabel>Total</FormLabel>
                            <FormControl>
                                <TextInput
                                    v-model="form.total"
                                    type="number"
                                    step="0.01"
                                    required
                                    class="w-full"
                                />
                            </FormControl>
                        </FormItem>
                    </FormField>
                </div>
                <div class="flex flex-col gap-1 w-full">
                    <FormField name="document">
                        <FormItem class="w-full">
                            <FormLabel>Document (PDF/JPG/PNG)</FormLabel>
                            <FormControl>
                                <input
                                    type="file"
                                    @change="
                                        (e) =>
                                            (form.document = e.target.files[0])
                                    "
                                    class="w-full"
                                />
                            </FormControl>
                        </FormItem>
                    </FormField>
                </div>
                <div v-if="showPaymentAlert" class="col-span-2">
                    <div
                        class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-4"
                    >
                        <p class="font-semibold mb-2">
                            Do you want to send the proof to the Supplier?
                        </p>
                        <p class="mb-2">
                            If yes, please attach the payment proof file below.
                            The supplier will receive an email with the proof attached.
                        </p>
                        <FormField name="payment_receipt">
                            <FormItem class="w-full">
                                <FormLabel
                                    >Payment Proof
                                    (PDF/JPG/PNG)</FormLabel
                                >
                                <FormControl>
                                    <input
                                        type="file"
                                        @change="
                                            (e) =>
                                                (form.payment_receipt =
                                                    e.target.files[0])
                                        "
                                        class="w-full"
                                    />
                                </FormControl>
                            </FormItem>
                        </FormField>
                    </div>
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
                                        <SelectItem value="pending"
                                            >Pending</SelectItem
                                        >
                                        <SelectItem value="paid"
                                            >Paid</SelectItem
                                        >
                                    </SelectContent>
                                </Select>
                            </FormControl>
                        </FormItem>
                    </FormField>
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
