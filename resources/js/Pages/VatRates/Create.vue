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

const form = useForm({
    name: "",
    rate: "",
    active: true,
});
function submit() {
    form.post(route("vat-rates.store"));
}
</script>

<template>
    <AppLayout title="Create VAT Rate">
        <form @submit.prevent="submit" class="max-w-lg mx-auto space-y-4">
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
                    class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition"
                    :disabled="form.processing"
                >
                    {{ form.processing ? "Creating..." : "Create" }}
                </button>
            </div>
        </form>
    </AppLayout>
</template>
