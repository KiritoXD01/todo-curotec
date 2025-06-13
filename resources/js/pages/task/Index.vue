<script setup lang="ts">
import DataTable from '@/components/DataTable.vue';
import FormDialog from '@/components/task/FormDialog.vue';
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/AppLayout.vue';
import { useTaskStore } from '@/store/task';
import type { BreadcrumbItem, Pagination, Task } from '@/types';
import { Head } from '@inertiajs/vue3';
import { ColumnDef } from '@tanstack/vue-table';
import { onMounted, h } from 'vue';

interface Props {
    items: Pagination<Task>;
}

defineProps<Props>();

const store = useTaskStore();

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
            return value?.length > 25 ? `${value.slice(0, 25)}...` : value;
        },
    },
    {
        accessorKey: 'due_date',
        header: 'Due Date',
        cell: ({ row }) => {
            const date = row.getValue('due_date');
            return date ? new Date(date as string).toLocaleDateString() : '-';
        },
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
    {
        id: 'actions',
        header: 'Actions',
        cell: ({ row }) => {
            const task = row.original;
            return h('div', { class: 'flex gap-2' }, [
                h(Button, {
                    variant: 'outline',
                    size: 'sm',
                    onClick: () => {
                        store.setCurrentItem(task);
                        store.toggleDialog();
                    },
                }, 'Edit'),
                h(Button, {
                    variant: 'destructive',
                    size: 'sm',
                    onClick: () => store.deleteItem(task.id),
                }, 'Delete'),
            ]);
        },
    },
];

onMounted(() => {
    store.fetchItems();
});
</script>

<template>
    <Head title="Tasks" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="container mx-auto p-2">
            <Button variant="outline" @click="store.toggleDialog()">Create Task</Button>
            <FormDialog />
            <DataTable :columns="columns" :data="items.data" />
        </div>
    </AppLayout>
</template>
