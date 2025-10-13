<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { useForm } from "@inertiajs/vue3";
import {
    FormField,
    FormItem,
    FormLabel,
    FormControl,
    FormMessage,
} from "@/Components/ui/form";
import TextInput from "@/Components/TextInput.vue";

const props = defineProps({
    vatRate: Object,
});

const form = useForm({
    name: props.vatRate.name,
    rate: props.vatRate.rate,
    active: props.vatRate.active,
});

function submit() {
    form.put(route("vat-rates.update", props.vatRate.id));
}
</script>

<template>
    <AppLayout title="Edit VAT Rate">
        <form
            @submit.prevent="submit"
            class="max-w-lg mx-auto space-y-8 bg-white/80 dark:bg-slate-800/80 p-6 rounded-xl shadow"
        >
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
                    <FormMessage v-if="form.errors.name">{{
                        form.errors.name
                    }}</FormMessage>
                </FormItem>
            </FormField>
            <FormField name="rate">
                <FormItem class="w-full">
                    <FormLabel>Rate (%)</FormLabel>
                    <FormControl>
                        <TextInput
                            v-model="form.rate"
                            type="number"
                            step="0.01"
                            min="0"
                            max="100"
                            required
                            class="w-full"
                        />
                    </FormControl>
                    <FormMessage v-if="form.errors.rate">{{
                        form.errors.rate
                    }}</FormMessage>
                </FormItem>
            </FormField>
            <FormField name="active">
                <FormItem class="flex items-center gap-2">
                    <FormControl>
                        <input
                            type="checkbox"
                            v-model="form.active"
                            :true-value="true"
                            :false-value="false"
                            id="active"
                            class="h-4 w-4"
                        />
                    </FormControl>
                    <FormLabel for="active" class="mb-0">
                        {{ form.active ? "Active" : "Inactive" }}
                    </FormLabel>
                </FormItem>
            </FormField>
            <div class="flex justify-end">
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
