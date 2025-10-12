<script setup>
import { ref, onMounted, onUnmounted } from "vue";

const props = defineProps({
    options: {
        type: Array,

        required: true,
    },

    modelValue: {
        type: [String, Number],

        default: "",
    },

    placeholder: {
        type: String,

        default: "Search...",
    },

    labelField: {
        type: String,

        default: "name",
    },

    valueField: {
        type: String,

        default: "id",
    },

    displayFormat: {
        type: Function,

        default: null,
    },
});

const emits = defineEmits(["update:modelValue"]);

const searchQuery = ref("");
const dropdownOpen = ref(false);
const comboboxRef = ref(null);

function getFilteredOptions() {
    if (!searchQuery.value) return props.options;

    const query = searchQuery.value.toLowerCase();

    return props.options.filter((option) => {
        if (props.labelField === "name" && option.reference) {
            return (
                String(option[props.labelField])
                    .toLowerCase()

                    .includes(query) ||
                String(option.reference).toLowerCase().includes(query)
            );
        }

        return String(option[props.labelField]).toLowerCase().includes(query);
    });
}

function getDisplayText(option) {
    if (!option) return "";

    if (props.displayFormat) {
        return props.displayFormat(option);
    }

    return String(option[props.labelField]);
}

function getSelectedOption() {
    return props.options.find(
        (o) => String(o[props.valueField]) === String(props.modelValue),
    );
}

// Close dropdown when clicking outside

function handleClickOutside(event) {
    if (comboboxRef.value && !comboboxRef.value.contains(event.target)) {
        dropdownOpen.value = false;
    }
}

onMounted(() => {
    document.addEventListener("click", handleClickOutside);
});

onUnmounted(() => {
    document.removeEventListener("click", handleClickOutside);
});
</script>

<template>
    <div class="relative w-full article-combobox" ref="comboboxRef">
        <div class="w-full">
            <input
                type="text"
                class="w-full p-2 border border-gray-300 rounded-md"
                :value="
                    dropdownOpen
                        ? searchQuery
                        : getDisplayText(getSelectedOption())
                "
                @input="(e) => (searchQuery = e.target.value)"
                :placeholder="placeholder"
                @focus="
                    () => {
                        dropdownOpen = true;

                        searchQuery = '';
                    }
                "
                @click="
                    () => {
                        dropdownOpen = true;

                        searchQuery = '';
                    }
                "
            />
        </div>

        <div
            v-if="dropdownOpen"
            class="absolute w-full mt-1 max-h-60 overflow-auto z-50 bg-white rounded-md shadow-lg border border-gray-300"
        >
            <div
                v-if="getFilteredOptions().length === 0"
                class="p-2 text-center text-gray-500"
            >
                No results found
            </div>

            <div
                v-for="option in getFilteredOptions()"
                :key="option[valueField]"
                @click="
                    () => {
                        $emit('update:modelValue', option[valueField]);

                        dropdownOpen = false;

                        searchQuery = '';
                    }
                "
                class="p-2 hover:bg-gray-100 cursor-pointer"
            >
                {{ getDisplayText(option) }}
            </div>
        </div>
    </div>
</template>
