<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Brand, BreadcrumbItem } from '@/types';
import BrandTable from '@/components/brand/table/Table.vue';
import { Plus } from 'lucide-vue-next';
import Dialog from '@/components/brand/form/Dialog.vue';

interface Props {
    brands: {
        data: Brand[];
        current_page: number;
        per_page: number;
        total: number;
        last_page: number;
    }
}
defineProps<Props>()

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Brands',
        href: '/brands',
    },
];
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">

        <Head title="Brands" />
        <Dialog :icon="Plus" triggerText="New Brand" dialogDescription="Create a new brand for your coffees."
            triggerClass="absolute right-4 top-4" dialogTitle="New Brand" />

        <div v-if="brands && brands.data && brands.data.length > 0" class="flex flex-col gap-4 p-4">
            <BrandTable :brands="brands" />
        </div>
        <div v-else class="text-center text-gray-500 py-8">
            No brands found.
        </div>
    </AppLayout>
</template>
