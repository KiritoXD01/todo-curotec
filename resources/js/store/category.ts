import { defineStore } from 'pinia';
import { router } from '@inertiajs/vue3';
import { ref } from 'vue';
import type { Category, Pagination } from '@/types';

export const useCategoryStore = defineStore('category', () => {
    // State
    const items = ref<Category[]>([]);
    const loading = ref(false);
    const dialog = ref(false);
    const mode = ref<'create' | 'edit'>('create');
    const currentItem = ref<Category | null>(null);

    // Actions
    async function fetchItems(page = 1) {
        loading.value = true;
        try {
            router.get(`/categories?page=${page}`, {}, {
                preserveState: true,
                preserveScroll: true,
                onSuccess: (page) => {
                    const data = page.props.items as Pagination<Category>;
                    items.value = data.data;
                },
                onFinish: () => {
                    loading.value = false;
                },
            });
        } catch (error) {
            console.error('Error fetching categories:', error);
            loading.value = false;
            throw error;
        }
    }

    async function createItem(data: Partial<Category>) {
        try {
            router.post('/categories', data, {
                preserveScroll: true,
                onSuccess: (page) => {
                    const category = page.props.category as Category;
                    items.value.push(category);
                    toggleDialog();
                },
            });
        } catch (error) {
            console.error('Error creating category:', error);
            throw error;
        }
    }

    async function updateItem(id: number, data: Partial<Category>) {
        try {
            router.put(`/categories/${id}`, data, {
                preserveScroll: true,
                onSuccess: (page) => {
                    const category = page.props.category as Category;
                    const index = items.value.findIndex(item => item.id === id);
                    if (index !== -1) {
                        items.value[index] = category;
                    }
                    toggleDialog();
                },
            });
        } catch (error) {
            console.error('Error updating category:', error);
            throw error;
        }
    }

    async function deleteItem(id: number) {
        try {
            router.delete(`/categories/${id}`, {
                preserveScroll: true,
                onSuccess: () => {
                    items.value = items.value.filter(item => item.id !== id);
                },
            });
        } catch (error) {
            console.error('Error deleting category:', error);
            throw error;
        }
    }

    function toggleDialog() {
        dialog.value = !dialog.value;
        if (!dialog.value) {
            currentItem.value = null;
            mode.value = 'create';
        }
    }

    function setCurrentItem(item: Category | null) {
        currentItem.value = item;
        mode.value = item ? 'edit' : 'create';
    }

    return {
        // State
        items,
        loading,
        dialog,
        mode,
        currentItem,
        // Actions
        fetchItems,
        createItem,
        updateItem,
        deleteItem,
        toggleDialog,
        setCurrentItem,
    };
});
