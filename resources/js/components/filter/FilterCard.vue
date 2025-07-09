<script setup lang="ts">
import { Card, CardHeader } from '@/components/ui/card'
import { Filter, BrewingMethod } from '@/types';
import { DropdownMenu, DropdownMenuTrigger, DropdownMenuContent, DropdownMenuItem, DropdownMenuSeparator } from '@/components/ui/dropdown-menu'
import { MoreHorizontal } from 'lucide-vue-next'
import { toast } from 'vue-sonner';
import { router } from '@inertiajs/vue3';
import FilterDialog from './FilterDialog.vue';
import { ref } from 'vue';

const open = ref(false)

interface Props {
    filters: {
        data: Filter[],
        current_page: number,
        per_page: number,
        total: number,
    },
    brewingMethods: BrewingMethod[]
}

defineProps<Props>()

function deleteFilter(filterId: number) {
    if (confirm('Are you sure you want to delete this filter?')) {
        router.delete(route('filters.destroy', filterId), {
            preserveScroll: true,
            onSuccess: () => {
                toast.success('Filter deleted successfully!', {
                    position: 'top-center',
                })
            },
            onError: () => {
                toast.error('Failed to delete filter. Please try again.', {
                    position: 'top-center',
                })
            }
        })
    }
}
</script>

<template>
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-1 md:grid-cols-4">
        <Card v-for="filter in filters.data" :key="filter.id">
            <CardHeader class="flex flex-row items-center gap-4 relative">
                <DropdownMenu>
                    <DropdownMenuTrigger as-child>
                        <button class="absolute right-2 rounded-full p-1 hover:bg-neutral-100 dark:hover:bg-neutral-800"
                            aria-label="Open menu" type="button">
                            <MoreHorizontal class="size-5" />
                        </button>
                    </DropdownMenuTrigger>
                    <DropdownMenuContent align="end" class="w-32">
                        <FilterDialog dialogTitle="Edit Filter" dialogDescription="Edit the filter details."
                            :filter="filter" :brewing-methods="brewingMethods">
                            <template #trigger>
                                <DropdownMenuItem as-child @select.prevent="open = true">
                                    <span>Edit</span>
                                </DropdownMenuItem>
                            </template>
                        </FilterDialog>
                        <DropdownMenuSeparator />
                        <DropdownMenuItem @click="deleteFilter(filter.id)" variant="destructive">
                            Delete
                        </DropdownMenuItem>
                    </DropdownMenuContent>
                </DropdownMenu>
                <div class="flex flex-col">
                    <div class="font-semibold text-lg">{{ filter.brand }} {{ filter.name }}</div>
                    <div class="text-sm text-gray-500">Quantity: {{ filter.quantity }}</div>
                    <div v-if="filter.description" class="text-xs text-gray-400 mt-1">{{ filter.description }}</div>
                </div>
            </CardHeader>
        </Card>
    </div>
</template>