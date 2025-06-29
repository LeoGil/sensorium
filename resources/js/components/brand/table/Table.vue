<script setup lang="ts">
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table'
import { Brand } from '@/types';
import { ref } from 'vue';

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

</script>

<template>
    <Table>
        <TableHeader>
            <TableRow>
                <TableHead>Logo</TableHead>
                <TableHead>Name</TableHead>
                <TableHead>URL</TableHead>
                <TableHead>Actions</TableHead>
            </TableRow>
        </TableHeader>
        <TableBody>
            <template v-for="brand in brands.data" :key="brand.id">
                <TableRow class="hover:bg-gray-50">
                    <TableCell>
                        <img v-if="brand.logo" :src="brand.logo" alt="Brand Logo" class="w-10 object-cover" />
                    </TableCell>
                    <TableCell>{{ brand.name }}</TableCell>
                    <TableCell>
                        <a :href="brand.url" target="_blank" rel="noopener noreferrer"
                            class="hover:underline hover:text-blue-600 cursor-pointer">{{ brand.url }}</a>
                    </TableCell>
                    <TableCell class="flex space-x-2">
                        <!-- <BrandTableActions :brand="brand" /> -->
                    </TableCell>
                </TableRow>
            </template>
        </TableBody>
    </Table>
</template>
