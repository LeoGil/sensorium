<script setup lang="ts">
import WaterCard from '@/components/water/WaterCard.vue';
import PaginationWrapper from '@/components/PaginationWrapper.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Water, BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import { Plus } from 'lucide-vue-next';
import { Button } from '@/components/ui/button';

interface Props {
    waters: {
        data: Water[];
        current_page: number;
        per_page: number;
        total: number;
        last_page: number;
    };
}
defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Waters',
        href: '/waters',
    },
];
</script>
<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head title="Waters" />
        <Button class="absolute right-4 top-4">
            <Link :href="route('waters.create')" class="flex items-center gap-2">
                <Plus class="w-4 h-4" />
                New Water
            </Link>
        </Button>
        <div v-if="waters && waters.data && waters.data.length > 0" class="p-4">
            <WaterCard :waters="waters" />
            <div class="flex justify-end mt-4">
                <PaginationWrapper v-if="waters.last_page > 1" :current-page="waters.current_page"
                    :per-page="waters.per_page" :total="waters.total" />
            </div>
        </div>
        <div v-else class="text-center text-gray-500 py-8">
            <p>No waters found.</p>
            <p>Add your first water to get started.</p>
        </div>
    </AppLayout>
</template> 