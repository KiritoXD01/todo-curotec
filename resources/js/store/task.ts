import { defineStore } from 'pinia';
import { router } from '@inertiajs/vue3';
import { ref } from 'vue';
import type { Task, Pagination, ModeOptions } from '@/types';

export const useTaskStore = defineStore('task', () => {
    // State
    const items = ref<Task[]>([]);
    const loading = ref(false);
    const dialog = ref(false);
    const mode = ref<ModeOptions>('create');
    const currentItem = ref<Task | null>(null);

    // Actions
    async function fetchItems(url?: string) {
        loading.value = true;
        try {
            router.get(url || '/tasks', {}, {
                preserveState: true,
                preserveScroll: true,
                onSuccess: (page) => {
                    const data = page.props.items as Pagination<Task>;
                    items.value = data.data;
                },
                onFinish: () => {
                    loading.value = false;
                },
            });
        } catch (error) {
            console.error('Error fetching tasks:', error);
            loading.value = false;
            throw error;
        }
    }

    async function createItem(data: Partial<Task>) {
        try {
            router.post('/tasks', data, {
                preserveScroll: true,
                onSuccess: () => {
                    toggleDialog();
                },
            });
        } catch (error) {
            console.error('Error creating task:', error);
            throw error;
        }
    }

    async function updateItem(id: number, data: Partial<Task>) {
        try {
            router.put(`/tasks/${id}`, data, {
                preserveScroll: true,
                onSuccess: () => {
                    toggleDialog();
                },
            });
        } catch (error) {
            console.error('Error updating task:', error);
            throw error;
        }
    }

    async function deleteItem(id: number) {
        try {
            router.delete(`/tasks/${id}`, {
                preserveScroll: true,
                onSuccess: () => {
                    items.value = items.value.filter(item => item.id !== id);
                },
            });
        } catch (error) {
            console.error('Error deleting task:', error);
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

    function setCurrentItem(item: Task | null) {
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
