<script setup lang="ts">
import AppLogoIcon from '@/components/AppLogoIcon.vue';
import { usePage } from '@inertiajs/vue3';

const page = usePage();
const name = page.props.name;

defineProps<{
    title?: string;
    description?: string;
}>();
</script>

<template>
    <div
        class="relative grid h-dvh flex-col items-center justify-center px-8 sm:px-0 lg:max-w-none lg:grid-cols-2 lg:px-0">
        <div class="relative hidden h-full flex-col bg-muted p-0 text-white lg:flex dark:border-r">
            <img src="/auth_back.jpeg" alt="Auth background"
                class="absolute inset-0 w-full h-full object-cover" />
            <div class="absolute inset-0 bg-zinc-900/50" />
            <div class="absolute top-0 left-0 w-full flex items-center gap-2 p-8 z-10">
                <AppLogoIcon class="size-10 fill-current text-white" />
                <span class="text-2xl font-bold">{{ name }}</span>
            </div>
        </div>
        <div class="lg:p-8">
            <div class="mx-auto flex w-full flex-col justify-center space-y-6 sm:w-[350px]">
                <div class="flex flex-col space-y-2 text-center">
                    <h1 class="text-xl font-medium tracking-tight" v-if="title">{{ title }}</h1>
                    <p class="text-sm text-muted-foreground" v-if="description">{{ description }}</p>
                </div>
                <slot />
            </div>
        </div>
    </div>
</template>
