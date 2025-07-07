<script setup lang="ts">
import ContainerTypeCard from '@/components/container-type/ContainerTypeCard.vue';
import PaginationWrapper from '@/components/PaginationWrapper.vue';
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem, ContainerType } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import { Plus } from 'lucide-vue-next';
import ContainerTypeDialog from '@/components/container-type/ContainerTypeDialog.vue';


interface Props {
    containerTypes: {
        data: ContainerType[];
        current_page: number;
        per_page: number;
        total: number;
        last_page: number;
    };
}

defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Container Types',
        href: '/container-types',
    },
];

</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">

        <Head title="Container Types" />
        <div class="absolute right-4 top-4 flex items-center gap-2">
            <ContainerTypeDialog
                trigger-text="New Container Type"
                dialog-title="Create Container Type"
                dialog-description="Add a new container type to your inventory."
                :trigger-class="'flex items-center gap-2'"
                :icon="Plus"
            />
        </div>


        <div v-if="containerTypes && containerTypes.data && containerTypes.data.length > 0" class="p-4">
            <ContainerTypeCard :containerTypes="containerTypes" />
            <div class="flex justify-end mt-4">
                <PaginationWrapper v-if="containerTypes.last_page > 1" :current-page="containerTypes.current_page"
                    :per-page="containerTypes.per_page" :total="containerTypes.total" />
            </div>
        </div>
        <div v-else class="text-center text-gray-500 p-8">
            <p>No container types found.</p>
            <p>Container types are used to store and track your inventory.</p>
            <p>You can create a new container type by clicking the "New Container Type" button above.</p>
            <p>Container types can be used to store coffee, like a bag of coffee, or a box of coffee, or a falcon tube of
                coffee.</p>
        </div>

    </AppLayout>

</template>