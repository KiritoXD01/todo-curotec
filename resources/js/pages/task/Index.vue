<script setup lang="ts">
import DataTable from '@/components/DataTable.vue';
import { Button } from '@/components/ui/button';
import { Dialog, DialogContent, DialogHeader, DialogTrigger } from '@/components/ui/dialog';
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem, Pagination, Task } from '@/types';
import { Head } from '@inertiajs/vue3';
import { ColumnDef } from '@tanstack/vue-table';

interface Props {
    items: Pagination<Task>;
}

defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
    {
        title: 'Tasks',
        href: '/tasks',
    },
];

const columns: ColumnDef<Task>[] = [
    {
        accessorKey: 'title',
        header: 'Title',
        cell: ({ row }) => row.getValue('title'),
    },
    {
        accessorKey: 'description',
        header: 'Description',
        cell: ({ row }) => {
            const value = row.getValue('description') as string;
            return value.length > 25 ? `${value.slice(0, 25)}...` : value;
        },
    },
    {
        accessorKey: 'due_date',
        header: 'Due Date',
        cell: ({ row }) => row.getValue('due_date'),
    },
    {
        accessorKey: 'priority',
        header: 'Priority',
        cell: ({ row }) => row.getValue('priority'),
    },
    {
        accessorKey: 'status',
        header: 'Status',
        cell: ({ row }) => row.getValue('status'),
    },
];
</script>

<template>
    <Head title="Tasks" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="container mx-auto p-2">
            <Dialog>
                <DialogTrigger as-child>
                    <Button variant="outline">Create Task</Button>
                </DialogTrigger>
                <DialogContent class="sm:max-w-[425px]">
                    <DialogHeader></DialogHeader>
                </DialogContent>
            </Dialog>
            <DataTable :columns="columns" :data="items.data" />
        </div>
    </AppLayout>
</template>
