<script setup lang="ts">
import { Card, CardHeader, CardContent } from '@/components/ui/card'
import { BrewingMethod } from '@/types';
import { DropdownMenu, DropdownMenuTrigger, DropdownMenuContent, DropdownMenuItem, DropdownMenuSeparator } from '@/components/ui/dropdown-menu'
import { MoreHorizontal } from 'lucide-vue-next'
import { toast } from 'vue-sonner';
import { router } from '@inertiajs/vue3';
import BrewingMethodDialog from './BrewingMethodDialog.vue';
import { ref } from 'vue';
import { getInitials } from '@/composables/useInitials';
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';

const open = ref(false)

interface Props {
    brewingMethods: {
        data: BrewingMethod[],
        current_page: number,
        per_page: number,
        total: number,
    }
}

defineProps<Props>()

function deleteBrewingMethod(brewingMethodId: number) {
    confirm('Are you sure you want to delete this brewing method?') && router.delete(route('brewing-methods.destroy', brewingMethodId), {
        preserveScroll: true,
        onSuccess: () => {
            toast.success('Brewing method deleted successfully!', {
                position: 'top-center',
            })
        },
        onError: () => {
            toast.error('Failed to delete brewing method. Please try again.', {
                position: 'top-center',
            })
        }
    })
}
</script>

<template>
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-1 md:grid-cols-2 xl:grid-cols-3">
        <Card v-for="brewingMethod in brewingMethods.data" :key="brewingMethod.id">
            <CardHeader class="flex flex-row items-center gap-4 relative">
                <DropdownMenu>
                    <DropdownMenuTrigger as-child>
                        <button class="absolute right-2 rounded-full p-1 hover:bg-neutral-100 dark:hover:bg-neutral-800"
                            aria-label="Open menu" type="button">
                            <MoreHorizontal class="size-5" />
                        </button>
                    </DropdownMenuTrigger>
                    <DropdownMenuContent align="end" class="w-32">
                        <BrewingMethodDialog dialogTitle="Edit Brewing Method"
                            dialogDescription="Edit the brewing method details." :brewingMethod="brewingMethod">
                            <template #trigger>
                                <DropdownMenuItem as-child @select.prevent="open = true">
                                    <span>Edit</span>
                                </DropdownMenuItem>
                            </template>
                        </BrewingMethodDialog>
                        <DropdownMenuSeparator />
                        <DropdownMenuItem @click="deleteBrewingMethod(brewingMethod.id)" variant="destructive">
                            Delete
                        </DropdownMenuItem>
                    </DropdownMenuContent>
                </DropdownMenu>
                <Avatar class="size-15">
                    <AvatarImage v-if="brewingMethod.image_url" :src="brewingMethod.image_url" :alt="brewingMethod.name"
                        class="w-full h-full object-contain object-center" />
                    <AvatarFallback>{{ getInitials(brewingMethod.name) }}</AvatarFallback>
                </Avatar>
                <div>
                    <div class="font-semibold text-lg">{{ brewingMethod.name }}</div>
                </div>
            </CardHeader>
        </Card>
    </div>
</template>
