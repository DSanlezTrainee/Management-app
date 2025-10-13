<script setup>
import { ref, watch, onMounted } from "vue";
import { useForm, usePage } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";

const props = defineProps({
    company: Object,
});

const form = useForm({
    name: props.company?.name || "",
    address: props.company?.address || "",
    postal_code: props.company?.postal_code || "",
    city: props.company?.city || "",
    nif: props.company?.nif || "",
    logo: null,
});

const logoPreview = ref(
    props.company?.logo ? `/storage/${props.company.logo}` : null,
);

function handleLogoChange(e) {
    const file = e.target.files[0];
    if (file) {
        form.logo = file;
        logoPreview.value = URL.createObjectURL(file);
    }
}

function submit() {
    form.post(route("settings.company.update"), {
        forceFormData: true,
        onSuccess: () => {
            if (form.logo) {
                URL.revokeObjectURL(logoPreview.value);
            }
        },
    });
}

const page = usePage();
const showFlash = ref(false);

function startFlashTimer() {
    showFlash.value = true;
    setTimeout(() => {
        showFlash.value = false;
    }, 2000);
}

onMounted(() => {
    if (
        page.props.flash &&
        (page.props.flash.success || page.props.flash.error)
    ) {
        startFlashTimer();
    }
});

watch(
    () => page.props.flash,
    (newFlash) => {
        if (newFlash && (newFlash.success || newFlash.error)) {
            startFlashTimer();
        }
    },
    { deep: true },
);
</script>

<template>
    <AppLayout title="Company Settings">
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                Company Settings
            </h2>
            <div
                v-if="showFlash && page.props.flash && page.props.flash.success"
                class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded fixed top-24 right-4 z-50 shadow-lg"
                style="max-width: 300px"
            >
                <span class="font-medium">Success!</span>
                {{ page.props.flash.success }}
            </div>
            <div
                v-if="showFlash && page.props.flash && page.props.flash.error"
                class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded fixed top-24 right-4 z-50 shadow-lg"
                style="max-width: 300px"
            >
                <span class="font-medium">Error!</span>
                {{ page.props.flash.error }}
            </div>
        </template>
        <div class="max-w-xl mx-auto py-8">
            <form @submit.prevent="submit" class="space-y-6">
                <div class="flex flex-col items-center">
                    <label class="block text-sm font-medium text-gray-700 mb-2"
                        >Logo</label
                    >
                    <input
                        type="file"
                        accept="image/*"
                        @change="handleLogoChange"
                        class="mb-2"
                    />
                    <div v-if="logoPreview" class="mb-2">
                        <img
                            :src="logoPreview"
                            alt="Logo Preview"
                            class="h-20 object-contain border rounded"
                        />
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700"
                        >Name</label
                    >
                    <input
                        v-model="form.name"
                        type="text"
                        class="mt-1 block w-full rounded border-gray-300"
                        required
                    />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700"
                        >Address</label
                    >
                    <input
                        v-model="form.address"
                        type="text"
                        class="mt-1 block w-full rounded border-gray-300"
                    />
                </div>
                <div class="flex gap-2">
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700"
                            >Postal Code</label
                        >
                        <input
                            v-model="form.postal_code"
                            type="text"
                            class="mt-1 block w-full rounded border-gray-300"
                            placeholder="1234-567"
                        />
                    </div>
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700"
                            >City</label
                        >
                        <input
                            v-model="form.city"
                            type="text"
                            class="mt-1 block w-full rounded border-gray-300"
                        />
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700"
                        >NIF</label
                    >
                    <input
                        v-model="form.nif"
                        type="text"
                        class="mt-1 block w-full rounded border-gray-300"
                        required
                    />
                </div>
                <div class="flex justify-end">
                    <button
                        type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
                        :disabled="form.processing"
                    >
                        {{ form.processing ? "Saving..." : "Save" }}
                    </button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
