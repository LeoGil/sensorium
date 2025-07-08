<script setup lang="ts">
import WaterForm from '@/components/water/WaterForm.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Water, BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

interface Props {
    water: Water;
}
const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Waters',
        href: '/waters',
    },
    {
        title: props.water.name,
        href: route('waters.edit', props.water.id),
    }
];
const pageTitle = `Edit Water – ${props.water.name}`;
</script>
<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head :title="pageTitle" />
        <div class="w-full px-4 md:p-8">
            <WaterForm :initial="water" mode="edit" />
        </div>
    </AppLayout>
</template> 