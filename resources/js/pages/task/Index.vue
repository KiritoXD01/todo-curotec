<script setup lang="ts">
import DataTable from '@/components/DataTable.vue';
import FormDialog from '@/components/task/FormDialog.vue';
import { Button } from '@/components/ui/button';
import { useUpperFirstLetter } from '@/composables/useUpperFirstLetter';
import AppLayout from '@/layouts/AppLayout.vue';
import { useTaskStore } from '@/store/task';
import type { BreadcrumbItem, CategoryList, Collection, Pagination, Task } from '@/types';
import { Head } from '@inertiajs/vue3';
import { ColumnDef } from '@tanstack/vue-table';
import { ArrowUpDown } from 'lucide-vue-next';
import Swal from 'sweetalert2';
import { h, onMounted } from 'vue';

interface Props {
    items: Pagination<Task>;
    categories: Collection<CategoryList>;
}

defineProps<Props>();

const store = useTaskStore();
const { upperFirstLetter } = useUpperFirstLetter();

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
        header: ({ column }) => {
            return h(Button, {
                variant: 'ghost',
                onClick: () => column.toggleSorting(column.getIsSorted() === "asc"),
            },
                () => ['Title', h(ArrowUpDown, { class: 'ml-2 h-4 w-4' })])
        },
        cell: ({ row }) => row.getValue('title'),
    },
    {
        accessorKey: 'due_date',
        header: ({ column }) => {
            return h(Button, {
                variant: 'ghost',
                onClick: () => column.toggleSorting(column.getIsSorted() === "asc"),
            },
                () => ['Due Date', h(ArrowUpDown, { class: 'ml-2 h-4 w-4' })])
        },
        cell: ({ row }) => {
            const date = row.getValue('due_date');
            return date ? new Date(date as string).toLocaleDateString() : '-';
        },
    },
    {
        accessorKey: 'priority',
        header: ({ column }) => {
            return h(Button, {
                variant: 'ghost',
                onClick: () => column.toggleSorting(column.getIsSorted() === "asc"),
            },
                () => ['Priority', h(ArrowUpDown, { class: 'ml-2 h-4 w-4' })])
        },
        cell: ({ row }) => upperFirstLetter(row.getValue('priority')),
    },
    {
        accessorKey: 'status',
        header: ({ column }) => {
            return h(Button, {
                variant: 'ghost',
                onClick: () => column.toggleSorting(column.getIsSorted() === "asc"),
            },
                () => ['Status', h(ArrowUpDown, { class: 'ml-2 h-4 w-4' })])
        },
        cell: ({ row }) => upperFirstLetter(row.getValue('status')),
    },
    {
        accessorKey: 'created_at',
        header: ({ column }) => {
            return h(Button, {
                variant: 'ghost',
                onClick: () => column.toggleSorting(column.getIsSorted() === "asc"),
            },
                () => ['Created At', h(ArrowUpDown, { class: 'ml-2 h-4 w-4' })])
        },
        cell: ({ row }) => row.getValue('created_at'),
    },
    {
        accessorKey: 'updated_at',
        header: ({ column }) => {
            return h(Button, {
                variant: 'ghost',
                onClick: () => column.toggleSorting(column.getIsSorted() === "asc"),
            },
                () => ['Updated At', h(ArrowUpDown, { class: 'ml-2 h-4 w-4' })])
        },
        cell: ({ row }) => row.getValue('updated_at'),
    },
    {
        id: 'actions',
        header: 'Actions',
        cell: ({ row }) => {
            const task = row.original;
            return h('div', { class: 'flex gap-2' }, [
                h(
                    Button,
                    {
                        variant: 'outline',
                        size: 'sm',
                        onClick: () => {
                            store.setCurrentItem(task);
                            store.toggleDialog();
                        },
                    },
                    'Edit',
                ),
                h(
                    Button,
                    {
                        variant: 'destructive',
                        size: 'sm',
                        onClick: async () => {
                            const result = await Swal.fire({
                                title: 'Are you sure?',
                                text: "You won't be able to revert this!",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Yes, delete it!',
                            });

                            if (result.isConfirmed) {
                                Swal.fire({
                                    title: 'Deleting...',
                                    allowOutsideClick: false,
                                    didOpen: () => {
                                        Swal.showLoading();
                                    },
                                });

                                await store.deleteItem(task.id);

                                Swal.fire({
                                    title: 'Deleted!',
                                    text: 'Task has been deleted.',
                                    icon: 'success',
                                });
                            }
                        },
                    },
                    'Delete',
                ),
            ]);
        },
    },
];

const handlePageChange = (url: string) => {
    store.fetchItems(url);
};

onMounted(() => {
    store.fetchItems();
});
</script>

<template>

    <Head title="Tasks" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="container mx-auto space-y-4 p-2">
            <Button variant="outline" @click="store.toggleDialog()">Create Task</Button>
            <FormDialog :categories="categories.data" />
            <DataTable :columns="columns" :data="items.data" :pagination="items" @page-change="handlePageChange" />
        </div>
    </AppLayout>
</template>
