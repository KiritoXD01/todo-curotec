<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Dialog, DialogClose, DialogContent, DialogFooter, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import { FormControl, FormDescription, FormItem, FormLabel, FormMessage } from '@/components/ui/form';
import { Input } from '@/components/ui/input';
import { useTaskStore } from '@/store/task';
import { toTypedSchema } from '@vee-validate/zod';
import { Field as FormField, Form } from 'vee-validate';
import { z } from 'zod';

const store = useTaskStore();
const title = store.mode === 'create' ? 'Create Task' : 'Edit Task';
const formId = 'task-form';

interface FormData {
    title: string;
    description: string;
}

const formSchema = toTypedSchema(
    z.object({
        title: z.string().min(1).max(191),
        description: z.string().max(500),
    }),
);

function onSubmit(values: any): void {
    const data = values as FormData;
    console.log(data);
}
</script>

<template>
    <Form v-slot="{ handleSubmit }" as="task-form" :validation-schema="formSchema">
        <Dialog :open="store.openDialog">
            <DialogContent class="sm:max-w-[425px]">
                <DialogHeader>
                    <DialogTitle>{{ title }}</DialogTitle>
                </DialogHeader>
                <form :id="formId" @submit="handleSubmit($event, onSubmit)">
                    <FormField v-slot="{ componentField }" name="title">
                        <FormItem>
                            <FormLabel>Title</FormLabel>
                            <FormControl>
                                <Input type="text" placeholder="Title..." v-bind="componentField" />
                            </FormControl>
                            <FormDescription> The title for the task</FormDescription>
                            <FormMessage />
                        </FormItem>
                    </FormField>
                </form>
                <DialogFooter>
                    <DialogClose as-child>
                        <Button type="button" variant="secondary" @click="store.toggleDialog()"> Close</Button>
                    </DialogClose>
                    <Button type="submit" :form="formId"> Save</Button>
                </DialogFooter>
            </DialogContent>
        </Dialog>
    </Form>
</template>
