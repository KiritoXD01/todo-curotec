<script setup lang="ts">
import FormDialog from '@/components/category/FormDialog.vue';
import DataTable from '@/components/DataTable.vue';
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem, Category, Pagination } from '@/types';
import { Head } from '@inertiajs/vue3';
import { ColumnDef } from '@tanstack/vue-table';
import { ref } from 'vue';

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

const openDialog = ref(false);

const toggleDialog = () => (openDialog.value = !openDialog.value);
</script>

<template>
    <Head title="Categories" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="container mx-auto p-2">
            <Button variant="outline" @click="toggleDialog">Create Category</Button>
            <FormDialog mode="create" :open="openDialog" />
            <DataTable :columns="columns" :data="items.data" />
        </div>
    </AppLayout>
</template>
