<script setup lang="ts">
import { Card, CardHeader, CardContent } from '@/components/ui/card'
import { Grinder } from '@/types';
import { DropdownMenu, DropdownMenuTrigger, DropdownMenuContent, DropdownMenuItem, DropdownMenuSeparator } from '@/components/ui/dropdown-menu'
import { Link } from '@inertiajs/vue3';
import { MoreHorizontal } from 'lucide-vue-next'
import { toast } from 'vue-sonner';
import { router } from '@inertiajs/vue3';
import GrinderDialog from './GrinderDialog.vue';
import { ref } from 'vue';
import { getInitials } from '@/composables/useInitials';
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';

const open = ref(false)

interface Props {
    grinders: {
        data: Grinder[],
        current_page: number,
        per_page: number,
        total: number,
    }
}

defineProps<Props>()

function deleteGrinder(grinderId: number) {
    confirm('Are you sure you want to delete this grinder?') && router.delete(route('grinders.destroy', grinderId), {
        preserveScroll: true,
        onSuccess: () => {
            toast.success('Grinder deleted successfully!', {
                position: 'top-center',
            })
        },
        onError: () => {
            toast.error('Failed to delete grinder. Please try again.', {
                position: 'top-center',
            })
        }
    })
}
</script>

<template>
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-1 md:grid-cols-2 xl:grid-cols-3">
        <Card v-for="grinder in grinders.data" :key="grinder.id">
            <CardHeader class="flex flex-row items-center gap-4 relative">
                <DropdownMenu>
                    <DropdownMenuTrigger as-child>
                        <button class="absolute right-2 rounded-full p-1 hover:bg-neutral-100 dark:hover:bg-neutral-800"
                            aria-label="Open menu" type="button">
                            <MoreHorizontal class="size-5" />
                        </button>
                    </DropdownMenuTrigger>
                    <DropdownMenuContent align="end" class="w-32">
                        <GrinderDialog dialogTitle="Edit Grinder" dialogDescription="Edit the grinder details."
                            :grinder="grinder">
                            <template #trigger>
                                <DropdownMenuItem as-child @select.prevent="open = true">
                                    <span>Edit</span>
                                </DropdownMenuItem>
                            </template>
                        </GrinderDialog>
                        <DropdownMenuSeparator />
                        <DropdownMenuItem @click="deleteGrinder(grinder.id)" variant="destructive">
                            Delete
                        </DropdownMenuItem>
                    </DropdownMenuContent>
                </DropdownMenu>
                <Avatar class="size-15">
                    <AvatarImage v-if="grinder.image_url" :src="grinder.image_url" :alt="grinder.name"
                        class="w-full h-full object-contain object-center" />
                    <AvatarFallback>{{ getInitials(grinder.name) }}</AvatarFallback>
                </Avatar>
                <div class="font-semibold text-lg">{{ grinder.name }}</div>
            </CardHeader>
            <CardContent class="flex flex-row gap-4">
                <div class="text-sm text-gray-500">Brand: {{ grinder.brand }}</div>
            </CardContent>
        </Card>
    </div>
</template>