<script setup lang="ts">
import DataTable from '@/components/DataTable.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem, Category } from '@/types';
import { Head } from '@inertiajs/vue3';
import { ColumnDef } from '@tanstack/vue-table';

interface Props {
    categories: Category[];
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
        cell: ({ row }) => row,
    },
];
</script>

<template>
    <Head title="Categories" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="container mx-auto p-2">
            <DataTable :columns="columns" :data="categories" />
        </div>
    </AppLayout>
</template>
