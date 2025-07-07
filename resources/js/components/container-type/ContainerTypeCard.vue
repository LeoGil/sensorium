<script setup lang="ts">
import { Card, CardHeader, CardContent } from '@/components/ui/card'
import { ContainerType } from '@/types';
import { DropdownMenu, DropdownMenuTrigger, DropdownMenuContent, DropdownMenuItem, DropdownMenuSeparator } from '@/components/ui/dropdown-menu'
import { Link } from '@inertiajs/vue3';
import { MoreHorizontal } from 'lucide-vue-next'
import { toast } from 'vue-sonner';
import { router } from '@inertiajs/vue3';
import ContainerTypeDialog from './ContainerTypeDialog.vue';
import { ref } from 'vue';

const open = ref(false)

interface Props {
    containerTypes: {
        data: ContainerType[],
        current_page: number,
        per_page: number,
        total: number,
    }
}

defineProps<Props>()

function deleteContainerType(containerTypeId: number) {
    confirm('Are you sure you want to delete this container type?') && router.delete(route('container-types.destroy', containerTypeId), {
        preserveScroll: true,
        onSuccess: () => {
            toast.success('Container type deleted successfully!', {
                position: 'top-center',
            })
        },
        onError: () => {
            toast.error('Failed to delete container type. Please try again.', {
                position: 'top-center',
            })
        }
    })
}
</script>

<template>
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-1 md:grid-cols-2 xl:grid-cols-3">
        <Card v-for="containerType in containerTypes.data" :key="containerType.id">
            <CardHeader class="flex flex-row items-center gap-4 relative">
                <DropdownMenu>
                    <DropdownMenuTrigger as-child>
                        <button class="absolute right-2 rounded-full p-1 hover:bg-neutral-100 dark:hover:bg-neutral-800"
                            aria-label="Open menu" type="button">
                            <MoreHorizontal class="size-5" />
                        </button>
                    </DropdownMenuTrigger>
                    <DropdownMenuContent align="end" class="w-32">
                        <DropdownMenuItem as-child>
                            <Link :href="route('container-types.edit', containerType.id)">Add Containers</Link>
                        </DropdownMenuItem>
                        <ContainerTypeDialog dialogTitle="Edit Container Type"
                            dialogDescription="Edit the container type details." :containerType="containerType">
                            <template #trigger>
                                <DropdownMenuItem as-child @select.prevent="open = true">
                                    <span>Edit</span>
                                </DropdownMenuItem>
                            </template>
                        </ContainerTypeDialog>
                        <DropdownMenuSeparator />
                        <DropdownMenuItem @click="deleteContainerType(containerType.id)" variant="destructive">
                            Delete
                        </DropdownMenuItem>
                    </DropdownMenuContent>
                </DropdownMenu>
                <div>
                    <Link :href="route('container-types.edit', containerType.id)" class="hover:underline">
                    <div class="font-semibold text-lg">{{ containerType.name }}</div>
                    </Link>
                </div>
            </CardHeader>
            <CardContent class="flex flex-row gap-4">
                <div class="text-sm text-gray-500">Capacity: {{ containerType.capacity }}g</div>
            </CardContent>
        </Card>
    </div>
</template>
