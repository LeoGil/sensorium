<script setup lang="ts">
import { Card, CardHeader, CardContent } from '@/components/ui/card'
import { Avatar, AvatarImage, AvatarFallback } from '@/components/ui/avatar'
import { Brand } from '@/types';
import { ref } from 'vue';
import { getInitials } from '@/composables/useInitials';
import { DropdownMenu, DropdownMenuTrigger, DropdownMenuContent, DropdownMenuItem, DropdownMenuSeparator } from '@/components/ui/dropdown-menu'
import { MoreHorizontal } from 'lucide-vue-next'
import BrandDialog from '@/components/brand/BrandDialog.vue';
import { toast } from 'vue-sonner';
import { router } from '@inertiajs/vue3';

const open = ref(false)

interface Props {
    brands: {
        data: Brand[],
        current_page: number,
        per_page: number,
        total: number,
    }
}

defineProps<Props>()

function deleteBrand(brandId: number) {
    confirm('Are you sure you want to delete this brand?') && router.delete(route('brands.destroy', brandId), {
        preserveScroll: true,
        onSuccess: () => {
            toast.success('Brand deleted successfully!', {
                position: 'top-center',
            })
        },
        onError: () => {
            toast.error('Failed to delete brand. Please try again.', {
                position: 'top-center',
            })
        }
    })
}
</script>

<template>
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-1 md:grid-cols-2 xl:grid-cols-3">
        <Card v-for="brand in brands.data" :key="brand.id">
            <CardHeader class="flex flex-row items-center gap-4 relative">
                <DropdownMenu>
                    <DropdownMenuTrigger as-child>
                        <button
                            class="absolute right-2 top-4 rounded-full p-1 hover:bg-neutral-100 dark:hover:bg-neutral-800"
                            aria-label="Open menu" type="button">
                            <MoreHorizontal class="size-5" />
                        </button>
                    </DropdownMenuTrigger>
                    <DropdownMenuContent align="end" class="w-32">
                        <BrandDialog dialogTitle="Edit Brand" dialogDesc="Edit the brand details." :brand="brand">
                            <template #trigger>
                                <DropdownMenuItem as-child @select.prevent="open = true">
                                    <span>Edit</span>
                                </DropdownMenuItem>
                            </template>
                        </BrandDialog>
                        <DropdownMenuSeparator />
                        <DropdownMenuItem @click="deleteBrand(brand.id)" variant="destructive">
                            Delete
                        </DropdownMenuItem>
                    </DropdownMenuContent>
                </DropdownMenu>
                <Avatar class="size-15">
                    <AvatarImage v-if="brand.logo" :src="brand.logo" :alt="brand.name"
                        class="w-full h-full object-contain object-center" />
                    <AvatarFallback>{{ getInitials(brand.name) }}</AvatarFallback>
                </Avatar>
                <div>
                    <div class="font-semibold text-lg">{{ brand.name }}</div>
                    <a :href="brand.url" target="_blank" rel="noopener noreferrer"
                        class="text-sm text-blue-600 hover:underline">
                        {{ brand.url }}
                    </a>
                </div>
            </CardHeader>
        </Card>
    </div>
</template>
