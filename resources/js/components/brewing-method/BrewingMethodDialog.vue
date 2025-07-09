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
import BrewingMethodForm from './BrewingMethodForm.vue';
import { BrewingMethod } from '@/types';

interface Props {
    triggerText?: string
    triggerClass?: string
    dialogTitle: string
    dialogDescription?: string
    icon?: FunctionalComponent
    brewingMethod?: BrewingMethod
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
            <BrewingMethodForm @success="open = false" :mode="brewingMethod ? 'edit' : 'create'"
                :initial="brewingMethod ?? {}" />
        </DialogContent>
    </Dialog>
</template>