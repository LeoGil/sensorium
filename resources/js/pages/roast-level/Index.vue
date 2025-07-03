<script setup lang="ts">
import PaginationWrapper from '@/components/PaginationWrapper.vue';
import RoastLevelDialog from '@/components/roast-level/RoastLevelDialog.vue';
import RoastLevelTable from '@/components/roast-level/RoastLevelTable.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem, RoastLevel } from '@/types';
import { Head } from '@inertiajs/vue3';
import { Plus } from 'lucide-vue-next';


interface Props {
    roastLevels: {
        data: RoastLevel[];
        current_page: number;
        per_page: number;
        total: number;
        last_page: number;
    };
}

defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Roast Levels',
        href: '/roast-levels',
    },
];

</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">

        <Head title="Roast Levels" />
        <RoastLevelDialog :icon="Plus" triggerText="New Roast Level" dialogDescription="Create a new roast level for your coffees."
            triggerClass="absolute right-4 top-4" dialogTitle="New Roast Level" />

        <div v-if="roastLevels && roastLevels.data && roastLevels.data.length > 0" class="p-4">
            <RoastLevelTable :roastLevels="roastLevels.data" />
            <div class="flex justify-end mt-4">
                <PaginationWrapper v-if="roastLevels.last_page > 1" :current-page="roastLevels.current_page" :per-page="roastLevels.per_page"
                    :total="roastLevels.total" />
            </div>
        </div>
         <div v-else class="text-center text-gray-500 py-8">
            No roast levels found.
        </div>

    </AppLayout>

</template>