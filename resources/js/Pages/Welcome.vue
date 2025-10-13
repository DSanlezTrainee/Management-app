<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

function handleImageError() {
    document.getElementById("screenshot-container")?.classList.add("!hidden");
    document.getElementById("docs-card")?.classList.add("!row-span-1");
    document.getElementById("docs-card-content")?.classList.add("!flex-row");
    document.getElementById("background")?.classList.add("!hidden");
}
</script>

<template>
    <AppLayout title="Home">
        <div class="flex flex-col items-center justify-center min-h-[60vh]">
            <svg
                class="w-16 h-16 mb-4 text-cyan-600 dark:text-cyan-300"
                fill="none"
                stroke="currentColor"
                stroke-width="1.5"
                viewBox="0 0 48 48"
            >
                <rect
                    x="6"
                    y="12"
                    width="36"
                    height="28"
                    rx="4"
                    stroke-width="2.5"
                />
                <path
                    d="M6 20h36M18 28h12"
                    stroke-width="2.5"
                    stroke-linecap="round"
                />
            </svg>
            <h1
                class="text-3xl font-bold text-cyan-900 dark:text-cyan-100 mt-2"
            >
                Welcome{{
                    $page.props.auth?.user
                        ? ", " + $page.props.auth.user.name
                        : ""
                }}!
            </h1>
            <p
                class="mt-4 text-lg text-gray-700 dark:text-gray-200 text-center max-w-xl"
            >
                Your management area is ready to use.<br />
                Start by choosing an option from the menu above.<br />
                Have a productive day!
            </p>
        </div>
    </AppLayout>
</template>
