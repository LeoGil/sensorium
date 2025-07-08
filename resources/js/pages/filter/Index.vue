<script setup lang="ts">
import FilterCard from '@/components/filter/FilterCard.vue';
import PaginationWrapper from '@/components/PaginationWrapper.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem, Filter } from '@/types';
import { Head } from '@inertiajs/vue3';
import { Plus } from 'lucide-vue-next';
import FilterDialog from '@/components/filter/FilterDialog.vue';

interface Props {
    filters: {
        data: Filter[];
        current_page: number;
        per_page: number;
        total: number;
        last_page: number;
    };
}

defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Filters',
        href: '/filters',
    },
];
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head title="Filters" />
        <div class="absolute right-4 top-4 flex items-center gap-2">
            <FilterDialog
                trigger-text="New Filter"
                dialog-title="Create Filter"
                dialog-description="Add a new filter to your collection."
                :trigger-class="'flex items-center gap-2'"
                :icon="Plus"
            />
        </div>
        <div v-if="filters && filters.data && filters.data.length > 0" class="p-4">
            <FilterCard :filters="filters" />
            <div class="flex justify-end mt-4">
                <PaginationWrapper v-if="filters.last_page > 1" :current-page="filters.current_page"
                    :per-page="filters.per_page" :total="filters.total" />
            </div>
        </div>
        <div v-else class="text-center text-gray-500 p-8">
            <p>No filters found.</p>
            <p>Filters are used in various brewing methods to separate grounds from brewed coffee.</p>
            <p>You can create a new filter by clicking the "New Filter" button above.</p>
        </div>
    </AppLayout>
</template> 