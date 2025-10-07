<script setup>
import {
    Table,
    TableBody,
    TableCaption,
    TableCell,
    TableEmpty,
    TableFooter,
    TableHead,
    TableHeader,
    TableRow,
} from "@/Components/ui/table";
import { Link } from "@inertiajs/vue3";

defineProps({
    columns: Array, // [{ key: 'nif', label: 'NIF' }, ...]
    data: Array,
});
</script>

<template>
    <Table>
        <TableHeader>
            <TableRow>
                <TableHead v-for="col in columns" :key="col.key">
                    {{ col.label }}
                </TableHead>
            </TableRow>
        </TableHeader>
        <TableBody>
            <TableRow v-for="row in data" :key="row.id">
                <TableCell v-for="col in columns" :key="col.key">
                    <slot :name="`cell-${col.key}`" :row="row">
                        {{ row[col.key] }}
                    </slot>
                </TableCell>
            </TableRow>
            <TableRow v-if="!data || data.length === 0">
                <TableCell :colspan="columns.length">
                    <TableEmpty>No data found.</TableEmpty>
                </TableCell>
            </TableRow>
        </TableBody>
    </Table>
</template>
