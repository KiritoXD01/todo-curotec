import { defineStore } from 'pinia';
import { ref } from 'vue';

export const useCategoryStore = defineStore('category', () => {
    const openDialog = ref(false);
    const mode = ref<'create' | 'edit'>('create');

    function toggleDialog() {
        openDialog.value = !openDialog.value;
    }

    return {
        openDialog,
        mode,
        toggleDialog,
    };
});
