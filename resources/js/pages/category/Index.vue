<script setup lang="ts">
import DataTable from '@/components/DataTable.vue';
import FormDialog from '@/components/category/FormDialog.vue';
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/AppLayout.vue';
import { useCategoryStore } from '@/store/category';
import type { BreadcrumbItem, Category, Pagination } from '@/types';
import { Head } from '@inertiajs/vue3';
import { ColumnDef } from '@tanstack/vue-table';
import Swal from 'sweetalert2';
import { h, onMounted } from 'vue';

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
        accessorKey: 'parent_name',
        header: 'Parent',
        cell: ({ row }) => row.getValue('parent_name') || '-',
    },
    {
        accessorKey: 'created_at',
        header: 'Created At',
        cell: ({ row }) => row.getValue('created_at'),
    },
    {
        accessorKey: 'updated_at',
        header: 'Updated At',
        cell: ({ row }) => row.getValue('updated_at'),
    },
    {
        id: 'actions',
        header: 'Actions',
        cell: ({ row }) => {
            const category = row.original;
            return h('div', { class: 'flex gap-2' }, [
                h(
                    Button,
                    {
                        variant: 'outline',
                        size: 'sm',
                        onClick: () => {
                            store.setCurrentItem(category);
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

                                await store.deleteItem(category.id);

                                Swal.fire({
                                    title: 'Deleted!',
                                    text: 'Category has been deleted.',
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

const store = useCategoryStore();

const handlePageChange = (url: string) => {
    store.fetchItems(url);
};

onMounted(() => {
    store.fetchItems();
});
</script>

<template>
    <Head title="Categories" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="container mx-auto space-y-4 p-2">
            <Button variant="outline" @click="store.toggleDialog()">Create Category</Button>
            <FormDialog />
            <DataTable :columns="columns" :data="items.data" :pagination="items" @page-change="handlePageChange" />
        </div>
    </AppLayout>
</template>
