<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Dialog, DialogContent, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import { FormControl, FormField, FormItem, FormLabel, FormMessage } from '@/components/ui/form';
import { Input } from '@/components/ui/input';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { useUpperFirstLetter } from '@/composables/useUpperFirstLetter';
import { TaskPriorityEnum, TaskStatusEnum } from '@/enums/enums';
import { useTaskStore } from '@/store/task';
import { CategoryList } from '@/types';
import { toTypedSchema } from '@vee-validate/zod';
import Swal from 'sweetalert2';
import { useForm } from 'vee-validate';
import { watch } from 'vue';
import * as z from 'zod';

const { categories } = defineProps<{
    categories: CategoryList[];
}>();

const store = useTaskStore();
const { upperFirstLetter } = useUpperFirstLetter();

const formSchema = toTypedSchema(
    z.object({
        title: z.string().min(1, 'Title is required'),
        description: z.string().optional(),
        due_date: z.string().optional(),
        priority: z.nativeEnum(TaskPriorityEnum),
        status: z.nativeEnum(TaskStatusEnum),
        category_id: z.number(),
        subcategory_id: z.number().optional(),
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
                text: 'Task has been created successfully',
                timer: 1500,
                showConfirmButton: false,
            });
        } else if (store.currentItem) {
            await store.updateItem(store.currentItem.id, values);
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'Task has been updated successfully',
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
                title: newItem.title,
                description: newItem.description || '',
                due_date: newItem.due_date ? new Date(newItem.due_date).toISOString().split('T')[0] : '',
                priority: newItem.priority,
                status: newItem.status,
                category_id: newItem.category_id || undefined,
                subcategory_id: newItem.subcategory_id || undefined,
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
                <DialogTitle>{{ store.mode === 'create' ? 'Create' : 'Edit' }} Task</DialogTitle>
            </DialogHeader>

            <form @submit="onSubmit" class="space-y-4">
                <FormField v-slot="{ componentField }" name="title">
                    <FormItem>
                        <FormLabel>Title</FormLabel>
                        <FormControl>
                            <Input v-bind="componentField" />
                        </FormControl>
                        <FormMessage />
                    </FormItem>
                </FormField>

                <FormField v-slot="{ componentField }" name="description">
                    <FormItem>
                        <FormLabel>Description</FormLabel>
                        <FormControl>
                            <Input v-bind="componentField" />
                        </FormControl>
                        <FormMessage />
                    </FormItem>
                </FormField>

                <FormField v-slot="{ componentField }" name="due_date">
                    <FormItem>
                        <FormLabel>Due Date</FormLabel>
                        <FormControl>
                            <Input type="date" v-bind="componentField" :min="new Date().toISOString().split('T')[0]" />
                        </FormControl>
                        <FormMessage />
                    </FormItem>
                </FormField>

                <FormField v-slot="{ componentField }" name="category_id">
                    <FormItem>
                        <FormLabel>Category</FormLabel>
                        <Select v-bind="componentField" class="w-full">
                            <FormControl>
                                <SelectTrigger class="w-full">
                                    <SelectValue placeholder="Select category" />
                                </SelectTrigger>
                            </FormControl>
                            <SelectContent>
                                <SelectItem v-for="category in categories" :key="category.id" :value="category.id">
                                    {{ category.name }}
                                </SelectItem>
                            </SelectContent>
                        </Select>
                        <FormMessage />
                    </FormItem>
                </FormField>

                <FormField v-slot="{ componentField }" name="subcategory_id">
                    <FormItem>
                        <FormLabel>Subcategory (Optional)</FormLabel>
                        <Select v-bind="componentField" class="w-full">
                            <FormControl>
                                <SelectTrigger class="w-full">
                                    <SelectValue placeholder="Select subcategory" />
                                </SelectTrigger>
                            </FormControl>
                            <SelectContent>
                                <SelectItem
                                    v-for="subcategory in categories.filter((c) => c.parent_id === form.values.category_id)"
                                    :key="subcategory.id" :value="subcategory.id">
                                    {{ subcategory.name }}
                                </SelectItem>
                            </SelectContent>
                        </Select>
                        <FormMessage />
                    </FormItem>
                </FormField>

                <FormField v-slot="{ componentField }" name="priority">
                    <FormItem>
                        <FormLabel>Priority</FormLabel>
                        <Select v-bind="componentField" class="w-full">
                            <FormControl>
                                <SelectTrigger class="w-full">
                                    <SelectValue placeholder="Select priority" />
                                </SelectTrigger>
                            </FormControl>
                            <SelectContent>
                                <SelectItem v-for="priority in Object.values(TaskPriorityEnum)" :key="priority"
                                    :value="priority">
                                    {{ upperFirstLetter(priority) }}
                                </SelectItem>
                            </SelectContent>
                        </Select>
                        <FormMessage />
                    </FormItem>
                </FormField>

                <FormField v-slot="{ componentField }" name="status">
                    <FormItem>
                        <FormLabel>Status</FormLabel>
                        <Select v-bind="componentField" class="w-full">
                            <FormControl>
                                <SelectTrigger class="w-full">
                                    <SelectValue placeholder="Select status" />
                                </SelectTrigger>
                            </FormControl>
                            <SelectContent>
                                <SelectItem v-for="status in Object.values(TaskStatusEnum)" :key="status"
                                    :value="status">
                                    {{ upperFirstLetter(status) }}
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
