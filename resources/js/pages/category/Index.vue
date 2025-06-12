<script setup lang="ts">
import FormDialog from '@/components/category/FormDialog.vue';
import DataTable from '@/components/DataTable.vue';
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/AppLayout.vue';
import { useCategoryStore } from '@/store/category';
import type { BreadcrumbItem, Category, Pagination } from '@/types';
import { Head } from '@inertiajs/vue3';
import { ColumnDef } from '@tanstack/vue-table';

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
        header: 'Created at',
        cell: ({ row }) => row.getValue('created_at'),
    },
];

const store = useCategoryStore();
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
