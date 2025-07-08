<script setup lang="ts">
import GrinderCard from '@/components/grinder/GrinderCard.vue';
import PaginationWrapper from '@/components/PaginationWrapper.vue';
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem, Grinder } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import { Plus } from 'lucide-vue-next';
import GrinderDialog from '@/components/grinder/GrinderDialog.vue';


interface Props {
    grinders: {
        data: Grinder[];
        current_page: number;
        per_page: number;
        total: number;
        last_page: number;
    };
}

defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Grinders',
        href: '/grinders',
    },
];

</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">

        <Head title="Grinders" />
        <div class="absolute right-4 top-4 flex items-center gap-2">
            <GrinderDialog
                trigger-text="New Grinder"
                dialog-title="Create Grinder"
                dialog-description="Add a new grinder to your collection."
                :trigger-class="'flex items-center gap-2'"
                :icon="Plus"
            />
        </div>


        <div v-if="grinders && grinders.data && grinders.data.length > 0" class="p-4">
            <GrinderCard :grinders="grinders" />
            <div class="flex justify-end mt-4">
                <PaginationWrapper v-if="grinders.last_page > 1" :current-page="grinders.current_page"
                    :per-page="grinders.per_page" :total="grinders.total" />
            </div>
        </div>
        <div v-else class="text-center text-gray-500 p-8">
            <p>No grinders found.</p>
            <p>Grinders are used to grind coffee beans for brewing.</p>
            <p>You can create a new grinder by clicking the "New Grinder" button above.</p>
            <p>Grinders can be manual or electric, and come in various brands and models.</p>
        </div>

    </AppLayout>

</template> 