<script setup lang="ts">
import { RoastLevel } from '@/types';
import { Button } from '@/components/ui/button';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import RoastLevelDialog from './RoastLevelDialog.vue';
import { router } from '@inertiajs/vue3';
import { toast } from 'vue-sonner';

interface Props {
    roastLevels: RoastLevel[];
}

defineProps<Props>();

function deleteRoastLevel(roastLevelId: number) {
    if (confirm('Are you sure you want to delete this roast level?')) {
        router.delete(route('roast-levels.destroy', roastLevelId), {
            preserveScroll: true,
            onSuccess: () => {
                toast.success('Roast level deleted successfully!', {
                    position: 'top-center',
                })
            },
            onError: () => {
                toast.error('Failed to delete roast level. Please try again.', {
                    position: 'top-center',
                })
            }
        })
    }
}
</script>

<template>
    <Table>
        <TableHeader>
            <TableRow>
                <TableHead>Name</TableHead>
                <TableHead>Description</TableHead>
                <TableHead class="w-2/12 text-right">Actions</TableHead>
            </TableRow>
        </TableHeader>
        <TableBody>
            <TableRow v-for="roast in roastLevels" :key="roast.id">
                <TableCell>{{ roast.name }}</TableCell>
                <TableCell>{{ roast.description || '-' }}</TableCell>
                <TableCell class="flex gap-2 justify-end">
                    <RoastLevelDialog :dialogTitle="`Edit roast level - ${roast.name}`" dialogDesc="Edit the roast level details."
                        :roastLevel="roast">
                        <template #trigger>
                            <Button size="sm" variant="outline">Edit</Button>
                        </template>
                    </RoastLevelDialog>
                    <Button size="sm" variant="destructive" @click="deleteRoastLevel(roast.id)">Delete</Button>
                </TableCell>
            </TableRow>
        </TableBody>
    </Table>
</template>
