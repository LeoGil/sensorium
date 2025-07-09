<script setup lang="ts">
import { Button } from '@/components/ui/button'
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/components/ui/dialog'
import { FunctionalComponent, ref } from 'vue';
import FilterForm from './FilterForm.vue';
import { BrewingMethod, Filter } from '@/types';

interface Props {
    triggerText?: string
    triggerClass?: string
    dialogTitle: string
    dialogDescription?: string
    icon?: FunctionalComponent
    filter?: Filter
    brewingMethods: BrewingMethod[]
}

defineProps<Props>()

const open = ref(false)
</script>

<template>
    <Dialog v-model:open="open">
        <DialogTrigger as-child>
            <template v-if="$slots.trigger">
                <slot name="trigger" />
            </template>
            <template v-else>
                <Button :class="triggerClass ?? ''">
                    <component :is="icon" v-if="icon" class="h-4 w-4 mr-1" />
                    {{ triggerText }}
                </Button>
            </template>
        </DialogTrigger>

        <DialogContent class="sm:max-w-[500px]">
            <DialogHeader>
                <DialogTitle>{{ dialogTitle }}</DialogTitle>
                <DialogDescription>
                    {{ dialogDescription }}
                </DialogDescription>
            </DialogHeader>
            <FilterForm @success="open = false" :mode="filter ? 'edit' : 'create'" :initial="filter ?? {}"
                :brewing-methods="brewingMethods" />
        </DialogContent>
    </Dialog>
</template>