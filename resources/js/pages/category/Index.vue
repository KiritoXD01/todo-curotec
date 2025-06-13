<script setup lang="ts">
import DataTable from '@/components/DataTable.vue';
import FormDialog from '@/components/category/FormDialog.vue';
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/AppLayout.vue';
import { useCategoryStore } from '@/store/category';
import type { BreadcrumbItem, Pagination, Category } from '@/types';
import { Head } from '@inertiajs/vue3';
import { ColumnDef } from '@tanstack/vue-table';
import { onMounted } from 'vue';

interface Props {
    items: Pagination<Category>;
}

defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
    {
        title: 'Categories',
        href: '/categories',
    },
];

const columns: ColumnDef<Category>[] = [
    {
        accessorKey: 'name',
        header: 'Name',
        cell: ({ row }) => row.getValue('name'),
    },
    {
        accessorKey: 'created_at',
        header: 'Created At',
        cell: ({ row }) => new Date(row.getValue('created_at')).toLocaleDateString(),
    },
];

const store = useCategoryStore();

onMounted(() => {
    store.fetchItems();
});
</script>

<template>
    <Head title="Categories" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="container mx-auto p-2">
            <Button variant="outline" @click="store.toggleDialog()">Create Category</Button>
            <FormDialog />
            <DataTable :columns="columns" :data="items.data" />
        </div>
    </AppLayout>
</template>
