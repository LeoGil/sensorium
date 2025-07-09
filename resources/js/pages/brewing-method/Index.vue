<script setup lang="ts">
import BrewingMethodCard from '@/components/brewing-method/BrewingMethodCard.vue';
import PaginationWrapper from '@/components/PaginationWrapper.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem, BrewingMethod } from '@/types';
import { Head } from '@inertiajs/vue3';
import BrewingMethodDialog from '@/components/brewing-method/BrewingMethodDialog.vue';
import { Plus } from 'lucide-vue-next';


interface Props {
    brewingMethods: {
        data: BrewingMethod[];
        current_page: number;
        per_page: number;
        total: number;
        last_page: number;
    };
}

defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Brewing Methods',
        href: '/brewing-methods',
    },
];

</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">

        <Head title="Brewing Methods" />
        <div class="absolute right-4 top-4 flex items-center gap-2">
            <BrewingMethodDialog trigger-text="New Brewing Method" dialog-title="Create Brewing Method"
                dialog-description="Add a new brewing method to your inventory."
                :trigger-class="'flex items-center gap-2'" :icon="Plus" />
        </div>

        <div v-if="brewingMethods && brewingMethods.data && brewingMethods.data.length > 0" class="p-4">
            <BrewingMethodCard :brewingMethods="brewingMethods" />
            <div class="flex justify-end mt-4">
                <PaginationWrapper v-if="brewingMethods.last_page > 1" :current-page="brewingMethods.current_page"
                    :per-page="brewingMethods.per_page" :total="brewingMethods.total" />
            </div>
        </div>
        <div v-else class="text-center text-gray-500 py-8">
            <p>No brewing methods found.</p>
            <p>Create your first brewing method to get started.</p>
            <p>It could be anything from a Gaggia Classic to a V60.</p>
        </div>

    </AppLayout>

</template>