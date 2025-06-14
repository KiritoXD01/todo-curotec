<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Dialog, DialogContent, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import { FormControl, FormField, FormItem, FormLabel, FormMessage } from '@/components/ui/form';
import { Input } from '@/components/ui/input';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { useCategoryStore } from '@/store/category';
import { toTypedSchema } from '@vee-validate/zod';
import Swal from 'sweetalert2';
import { useForm } from 'vee-validate';
import { watch } from 'vue';
import * as z from 'zod';

const store = useCategoryStore();

const formSchema = toTypedSchema(
    z.object({
        name: z.string().min(1, 'Name is required').max(191, 'Name must be less than 191 characters'),
        parent_id: z.number().optional(),
    }),
);

const form = useForm({
    validationSchema: formSchema,
});

const onSubmit = form.handleSubmit(async (values) => {
    try {
        Swal.fire({
            title: 'Processing...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            },
        });

        if (store.mode === 'create') {
            await store.createItem(values);
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'Category has been created successfully',
                timer: 1500,
                showConfirmButton: false,
            });
        } else if (store.currentItem) {
            await store.updateItem(store.currentItem.id, values);
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'Category has been updated successfully',
                timer: 1500,
                showConfirmButton: false,
            });
        }
        form.resetForm();
    } catch (error) {
        console.error('Error submitting form:', error);
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Something went wrong! Please try again.',
        });
    }
});

watch(
    () => store.currentItem,
    (newItem) => {
        if (newItem) {
            form.setValues({
                name: newItem.name,
                parent_id: newItem.parent_id || undefined,
            });
        } else {
            form.resetForm();
        }
    },
);
</script>

<template>
    <Dialog :open="store.dialog" @update:open="store.toggleDialog">
        <DialogContent>
            <DialogHeader>
                <DialogTitle>{{ store.mode === 'create' ? 'Create' : 'Edit' }} Category</DialogTitle>
            </DialogHeader>

            <form @submit="onSubmit" class="space-y-4">
                <FormField v-slot="{ componentField }" name="name">
                    <FormItem>
                        <FormLabel>Name</FormLabel>
                        <FormControl>
                            <Input v-bind="componentField" />
                        </FormControl>
                        <FormMessage />
                    </FormItem>
                </FormField>

                <FormField v-slot="{ componentField }" name="parent_id">
                    <FormItem>
                        <FormLabel>Parent</FormLabel>
                        <Select v-bind="componentField" class="w-full">
                            <FormControl>
                                <SelectTrigger class="w-full">
                                    <SelectValue placeholder="Select parent" />
                                </SelectTrigger>
                            </FormControl>
                            <SelectContent class="w-full">
                                <SelectItem v-for="item in store.items.filter((item) => item.parent_id === null)" :key="item.id" :value="item.id">
                                    {{ item.name }}
                                </SelectItem>
                            </SelectContent>
                        </Select>
                        <FormMessage />
                    </FormItem>
                </FormField>

                <div class="mt-4 flex justify-end gap-2">
                    <Button type="button" variant="outline" @click="store.toggleDialog"> Cancel </Button>
                    <Button type="submit">
                        {{ store.mode === 'create' ? 'Create' : 'Update' }}
                    </Button>
                </div>
            </form>
        </DialogContent>
    </Dialog>
</template>
