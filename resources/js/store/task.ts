import { ModeOptions } from '@/types';
import { defineStore } from 'pinia';
import { ref } from 'vue';

export const useTaskStore = defineStore('task', () => {
    const openDialog = ref<boolean>(false);
    const mode = ref<ModeOptions>('create');

    function toggleDialog(selectedMode: ModeOptions = 'create') {
        openDialog.value = !openDialog.value;
        mode.value = selectedMode;
    }

    return {
        openDialog,
        mode,
        toggleDialog,
    };
});
