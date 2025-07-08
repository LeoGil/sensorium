<script setup lang="ts">
import WaterForm from '@/components/water/WaterForm.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Waters',
        href: '/waters',
    },
    {
        title: 'Create Water',
        href: route('waters.create'),
    }
];
const pageTitle = 'Create Water';
</script>
<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head :title="pageTitle" />
        <div class="w-full px-4 md:p-8">
            <WaterForm :initial="{}" mode="create" />
        </div>
    </AppLayout>
</template> 