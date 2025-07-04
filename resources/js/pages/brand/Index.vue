<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Brand, BreadcrumbItem } from '@/types';
import BrandCard from '@/components/brand/BrandCard.vue';
import { Plus } from 'lucide-vue-next';
import BrandDialog from '@/components/brand/BrandDialog.vue';
import PaginationWrapper from '@/components/PaginationWrapper.vue';

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
        <BrandDialog :icon="Plus" triggerText="New Brand" dialogDescription="Create a new brand for your coffees."
            triggerClass="absolute right-4 top-4" dialogTitle="New Brand" />

        <div v-if="brands && brands.data && brands.data.length > 0" class="p-4">
            <BrandCard :brands="brands" />
            <div class="flex justify-end mt-4">
                <PaginationWrapper v-if="brands.last_page > 1" :current-page="brands.current_page"
                    :per-page="brands.per_page" :total="brands.total" />
            </div>
        </div>
        <div v-else class="text-center text-gray-500 py-8">
            No brands found.
        </div>
    </AppLayout>
</template>
