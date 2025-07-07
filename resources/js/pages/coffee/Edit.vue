<script setup lang="ts">
import CoffeeForm from '@/components/coffee/CoffeeForm.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Brand, BreadcrumbItem, Coffee, RoastLevel } from '@/types';
import { Head } from '@inertiajs/vue3';


interface Props {
    coffee: Coffee;
    roastLevels: RoastLevel[];
    brands: Brand[];
}

const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Coffees',
        href: '/coffees',
    },
    {
        title: props.coffee.name,
        href: route('coffees.edit', props.coffee.id),
    }
];

const pageTitle = `Edit Coffee – ${props.coffee.name}`;

</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">

        <Head :title="pageTitle" />
        <div class="w-full px-4 md:p-8">
            <CoffeeForm :initial="coffee" mode="edit" :roastLevels="roastLevels" :brands="brands" />
        </div>

    </AppLayout>

</template>