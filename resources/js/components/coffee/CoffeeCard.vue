<script setup lang="ts">
import { Card, CardHeader } from '@/components/ui/card'
import { Avatar, AvatarImage, AvatarFallback } from '@/components/ui/avatar'
import { Brand, Coffee, RoastLevel } from '@/types';
import { getInitials } from '@/composables/useInitials';
import { DropdownMenu, DropdownMenuTrigger, DropdownMenuContent, DropdownMenuItem, DropdownMenuSeparator } from '@/components/ui/dropdown-menu'
import { Link } from '@inertiajs/vue3';
import { MoreHorizontal } from 'lucide-vue-next'
import { toast } from 'vue-sonner';
import { router } from '@inertiajs/vue3';

interface Props {
    coffees: {
        data: Coffee[],
        current_page: number,
        per_page: number,
        total: number,
    }
    roastLevels: RoastLevel[]
    brands: Brand[]
}

defineProps<Props>()

function deleteCoffee(coffeeId: number) {
    confirm('Are you sure you want to delete this coffee?') && router.delete(route('coffees.destroy', coffeeId), {
        preserveScroll: true,
        onSuccess: () => {
            toast.success('Coffee deleted successfully!', {
                position: 'top-center',
            })
        },
        onError: () => {
            toast.error('Failed to delete coffee. Please try again.', {
                position: 'top-center',
            })
        }
    })
}
</script>

<template>
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-1 md:grid-cols-2 xl:grid-cols-3">
        <Card v-for="coffee in coffees.data" :key="coffee.id">
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
                        <DropdownMenuItem as-child>
                            <Link :href="route('coffees.edit', coffee.id)">Edit</Link>
                        </DropdownMenuItem>
                        <DropdownMenuSeparator />
                        <DropdownMenuItem @click="deleteCoffee(coffee.id)" variant="destructive">
                            Delete
                        </DropdownMenuItem>
                    </DropdownMenuContent>
                </DropdownMenu>
                <Avatar class="size-15">
                    <AvatarImage v-if="coffee.image" :src="coffee.image" :alt="coffee.name"
                        class="w-full h-full object-contain object-center" />
                    <AvatarFallback>{{ getInitials(coffee.name) }}</AvatarFallback>
                </Avatar>
                <div>
                    <Link :href="route('coffees.edit', coffee.id)" class="hover:underline">
                        <div class="font-semibold text-lg">{{ coffee.name }}</div>
                    </Link>
                </div>
            </CardHeader>
        </Card>
    </div>
</template>
