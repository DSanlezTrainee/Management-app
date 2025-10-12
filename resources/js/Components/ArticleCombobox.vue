<script setup>
import { ref, computed } from "vue";
import Combobox from "@/Components/ui/combobox/Combobox.vue";
import ComboboxTrigger from "@/Components/ui/combobox/ComboboxTrigger.vue";
import ComboboxAnchor from "@/Components/ui/combobox/ComboboxAnchor.vue";
import ComboboxList from "@/Components/ui/combobox/ComboboxList.vue";
import ComboboxItem from "@/Components/ui/combobox/ComboboxItem.vue";
import ComboboxEmpty from "@/Components/ui/combobox/ComboboxEmpty.vue";

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

const search = ref("");

const filteredOptions = computed(() => {
    if (!search.value) return props.options;
    const query = search.value.toLowerCase();
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
});

function getDisplayText(option) {
    if (!option) return "";
    if (props.displayFormat) {
        return props.displayFormat(option);
    }
    return String(option[props.labelField]);
}

const selectedOption = computed(() => {
    return props.options.find(
        (o) => String(o[props.valueField]) === String(props.modelValue),
    );
});
</script>

<template>
    <Combobox
        v-model="search"
        :modelValue="props.modelValue"
        @update:modelValue="(val) => emits('update:modelValue', val)"
        class="w-full"
        :openOnFocus="true"
        :openOnClick="true"
        :resetSearchTermOnSelect="true"
        :resetSearchTermOnBlur="true"
        :by="props.valueField"
    >
        <ComboboxAnchor class="w-full">
            <ComboboxTrigger class="w-full">
                <input
                    class="w-full p-2 border border-gray-300 rounded-md"
                    :placeholder="placeholder"
                    :value="search || getDisplayText(selectedOption)"
                    @input="(e) => (search = e.target.value)"
                />
            </ComboboxTrigger>
        </ComboboxAnchor>
        <ComboboxList
            class="w-full mt-1 max-h-60 overflow-auto z-50 bg-white rounded-md shadow-lg border border-gray-300"
        >
            <template v-if="filteredOptions.length === 0">
                <ComboboxEmpty>No results found</ComboboxEmpty>
            </template>
            <template v-else>
                <ComboboxItem
                    v-for="option in filteredOptions"
                    :key="option[valueField]"
                    :value="option[valueField]"
                    :textValue="getDisplayText(option)"
                    @select="
                        () => {
                            emits('update:modelValue', option[valueField]);
                            search = '';
                        }
                    "
                >
                    {{ getDisplayText(option) }}
                </ComboboxItem>
            </template>
        </ComboboxList>
    </Combobox>
</template>
