<script setup lang="ts">
import { Card, CardHeader } from '@/components/ui/card';
import { Water } from '@/types';
import { DropdownMenu, DropdownMenuTrigger, DropdownMenuContent, DropdownMenuItem, DropdownMenuSeparator } from '@/components/ui/dropdown-menu';
import { Link } from '@inertiajs/vue3';
import { MoreHorizontal } from 'lucide-vue-next';
import { toast } from 'vue-sonner';
import { router } from '@inertiajs/vue3';

interface Props {
    waters: {
        data: Water[];
        current_page: number;
        per_page: number;
        total: number;
    };
}
defineProps<Props>();

function deleteWater(waterId: number) {
    if (confirm('Are you sure you want to delete this water?')) {
        router.delete(route('waters.destroy', waterId), {
            preserveScroll: true,
            onSuccess: () => {
                toast.success('Water deleted successfully!', { position: 'top-center' });
            },
            onError: () => {
                toast.error('Failed to delete water. Please try again.', { position: 'top-center' });
            }
        });
    }
}
</script>
<template>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <Card v-for="water in waters.data" :key="water.id">
            <CardHeader class="flex flex-row items-center justify-between">
                <div>
                    <div class="font-semibold text-lg">{{ water.name }}</div>
                    <div class="text-xs text-gray-500">Hardness: {{ water.hardness }} mg/L | Alkalinity: {{
                        water.alkalinity }} mg/L</div>
                </div>
                <DropdownMenu>
                    <DropdownMenuTrigger as-child>
                        <button class="p-2">
                            <MoreHorizontal class="w-5 h-5" />
                        </button>
                    </DropdownMenuTrigger>
                    <DropdownMenuContent>
                        <DropdownMenuItem as-child>
                            <Link :href="route('waters.edit', water.id)">Edit</Link>
                        </DropdownMenuItem>
                        <DropdownMenuSeparator />
                        <DropdownMenuItem variant="destructive" @click="deleteWater(water.id)">Delete</DropdownMenuItem>
                    </DropdownMenuContent>
                </DropdownMenu>
            </CardHeader>
            <div class="px-6 pb-4">
                <div class="text-sm">Calcium: {{ water.calcium }} mg/L</div>
                <div class="text-sm">Magnesium: {{ water.magnesium }} mg/L</div>
                <div class="text-sm">Bicarbonate: {{ water.bicarbonate }} mg/L</div>
                <div class="text-sm">Chlorine: {{ water.chlorine ?? '-' }} mg/L</div>
                <div class="text-sm">TDS: {{ water.total_dissolved_solids ?? '-' }} mg/L</div>
                <div class="text-sm">pH: {{ water.ph ?? '-' }}</div>
                <div class="text-sm">Sodium: {{ water.sodium ?? '-' }} mg/L</div>
            </div>
        </Card>
    </div>
</template>