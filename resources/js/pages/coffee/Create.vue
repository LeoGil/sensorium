<script setup lang="ts">
import CoffeeForm from '@/components/coffee/CoffeeForm.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Brand, BreadcrumbItem, RoastLevel } from '@/types';
import { Head } from '@inertiajs/vue3';


interface Props {
    roastLevels: RoastLevel[];
    brands: Brand[];
}

defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Coffees',
        href: '/coffees',
    },
    {
        title: 'Create Coffee',
        href: route('coffees.create'),
    }
];

const pageTitle = 'Create Coffee';

</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">

        <Head :title="pageTitle" />
        <div class="w-full px-4 md:p-8">
            <CoffeeForm :initial="{}" mode="create" :roastLevels="roastLevels" :brands="brands" />
        </div>
    </AppLayout>
</template>