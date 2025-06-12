<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Dialog, DialogClose, DialogContent, DialogFooter, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { useCategoryStore } from '@/store/category';
import { useForm } from '@inertiajs/vue3';

const store = useCategoryStore();
const title = store.mode === 'create' ? 'Create Category' : 'Edit Category';
const formId = 'category-form';

const form = useForm({
    name: '',
});

const onSubmit = () => {
    form.post(route('categories.store'), {
        onSuccess: () => console.log('completed'),
        onError: () => console.log('error'),
    });
};
</script>

<template>
    <Dialog :open="store.openDialog">
        <DialogContent class="sm:max-w-[425px]">
            <DialogHeader>
                <DialogTitle>{{ title }}</DialogTitle>
            </DialogHeader>
            <form :id="formId" @submit.prevent="onSubmit" class="space-y-6">
                <div class="grid gap-2">
                    <Label for="email">Name</Label>
                    <Input
                        id="name"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.name"
                        required
                        autocomplete="off"
                        placeholder="Category Name"
                    />
                    <InputError class="mt-2" :message="form.errors.name" />
                </div>
            </form>
            <DialogFooter>
                <DialogClose as-child>
                    <Button type="button" variant="secondary" @click="store.toggleDialog()"> Close</Button>
                </DialogClose>
                <Button :form="formId">Save</Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>
