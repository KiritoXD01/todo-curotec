<script setup lang="ts" generic="TData, TValue">
import { Button } from '@/components/ui/button';
import { TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { valueUpdater } from '@/lib/utils';
import { ColumnDef, FlexRender, getCoreRowModel, getSortedRowModel, SortingState, useVueTable } from '@tanstack/vue-table';
import { ChevronLeft, ChevronRight } from 'lucide-vue-next';
import { ref } from 'vue';
import Table from './ui/table/Table.vue';

const props = defineProps<{
    columns: ColumnDef<TData, TValue>[];
    data: TData[];
    pagination?: {
        links: {
            first: string | null;
            last: string | null;
            next: string | null;
            prev: string | null;
        };
        meta: {
            current_page: number;
            current_page_url: string;
            from: number;
            path: string;
            per_page: number;
            to: number;
            total: number;
        };
    };
}>();

const emit = defineEmits<{
    (e: 'page-change', url: string): void;
}>();

const sorting = ref<SortingState>([])

const table = useVueTable({
    get data() {
        return props.data;
    },
    get columns() {
        return props.columns;
    },
    getCoreRowModel: getCoreRowModel(),
    getSortedRowModel: getSortedRowModel(),
    onSortingChange: updaterOrValue => valueUpdater(updaterOrValue, sorting),
    state: {
        get sorting() { return sorting.value },
    }
});

const handlePageChange = (url: string | null) => {
    if (url) {
        emit('page-change', url);
    }
};
</script>

<template>
    <div class="w-full">
        <div class="rounded-md border">
            <div class="relative w-full overflow-auto">
                <Table class="w-full caption-bottom text-sm">
                    <TableHeader>
                        <TableRow v-for="headerGroup in table.getHeaderGroups()" :key="headerGroup.id">
                            <TableHead v-for="header in headerGroup.headers" :key="header.id" class="whitespace-nowrap">
                                <FlexRender v-if="!header.isPlaceholder" :render="header.column.columnDef.header"
                                    :props="header.getContext()" />
                            </TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <template v-if="table.getRowModel().rows?.length">
                            <TableRow v-for="row in table.getRowModel().rows" :key="row.id"
                                :data-state="row.getIsSelected() ? 'selected' : undefined">
                                <TableCell v-for="cell in row.getVisibleCells()" :key="cell.id"
                                    class="whitespace-nowrap">
                                    <FlexRender :render="cell.column.columnDef.cell" :props="cell.getContext()" />
                                </TableCell>
                            </TableRow>
                        </template>
                        <template v-else>
                            <TableRow>
                                <TableCell :colspan="columns.length" class="h-24 text-center"> No results.</TableCell>
                            </TableRow>
                        </template>
                    </TableBody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div v-if="pagination" class="flex flex-col items-center justify-between gap-4 px-2 py-4 sm:flex-row">
            <div class="text-sm text-muted-foreground">
                Showing {{ pagination.meta.from }} to {{ pagination.meta.to }} of {{ pagination.meta.total }} entries
            </div>
            <div class="flex items-center space-x-2">
                <Button variant="outline" size="sm" :disabled="!pagination.links.prev"
                    @click="handlePageChange(pagination.links.prev)">
                    <ChevronLeft class="h-4 w-4" />
                    <span class="hidden sm:inline">Previous</span>
                </Button>
                <Button variant="outline" size="sm" :disabled="!pagination.links.next"
                    @click="handlePageChange(pagination.links.next)">
                    <span class="hidden sm:inline">Next</span>
                    <ChevronRight class="h-4 w-4" />
                </Button>
            </div>
        </div>
    </div>
</template>
