<script setup lang="ts">
import CoffeeCard from '@/components/coffee/CoffeeCard.vue';
import CoffeeDialog from '@/components/coffee/CoffeeDialog.vue';
import PaginationWrapper from '@/components/PaginationWrapper.vue';
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/AppLayout.vue';
import { Brand, BreadcrumbItem, Coffee, RoastLevel } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import { Plus } from 'lucide-vue-next';


interface Props {
    coffees: {
        data: Coffee[];
        current_page: number;
        per_page: number;
        total: number;
        last_page: number;
    };
    roastLevels: RoastLevel[];
    brands: Brand[];
}

defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Coffees',
        href: '/coffees',
    },
];

</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">

        <Head title="Coffees" />
        <Button as-child variant="default" class="absolute right-4 top-4 flex items-center gap-2">
            <Link :href="route('coffees.create')">
            <Plus class="w-4 h-4" />
            New Coffee
            </Link>
        </Button>


        <div v-if="coffees && coffees.data && coffees.data.length > 0" class="p-4">
            <CoffeeCard :coffees="coffees" :roastLevels="roastLevels" :brands="brands" />
            <div class="flex justify-end mt-4">
                <PaginationWrapper v-if="coffees.last_page > 1" :current-page="coffees.current_page"
                    :per-page="coffees.per_page" :total="coffees.total" />
            </div>
        </div>
        <div v-else class="text-center text-gray-500 py-8">
            No coffees found.
        </div>

    </AppLayout>

</template>