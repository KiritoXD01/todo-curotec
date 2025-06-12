<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Dialog, DialogClose, DialogContent, DialogFooter, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import { useCategoryStore } from '@/store/category';

const store = useCategoryStore();
const title = store.mode === 'create' ? 'Create Category' : 'Edit Category';
</script>

<template>
    <Dialog :open="store.openDialog">
        <DialogContent class="sm:max-w-[425px]">
            <DialogHeader>
                <DialogTitle>{{ title }}</DialogTitle>
            </DialogHeader>
            <DialogFooter>
                <DialogClose as-child>
                    <Button type="button" variant="secondary" @click="store.toggleDialog()"> Close</Button>
                </DialogClose>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>
