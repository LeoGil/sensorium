<script setup lang="ts">
import { Filter } from '@/types';
import { useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import InputError from '@/components/InputError.vue';
import { toast } from 'vue-sonner';

interface Props {
    mode: 'create' | 'edit'
    initial: Partial<Filter>
}
const props = defineProps<Props>()

const form = useForm<{
    brand: string;
    name: string;
    quantity: number | string;
    description?: string;
}>({
    brand: props.initial.brand ?? '',
    name: props.initial.name ?? '',
    quantity: props.initial.quantity ?? '',
    description: props.initial.description ?? '',
});

const emit = defineEmits<{
    (e: 'success'): void
}>()

form.transform((data) => ({
    ...data,
    _method: props.mode === 'edit' ? 'patch' : 'post',
}));

const submit = () => {
    const formRoute = props.mode === 'edit'
        ? route('filters.update', props.initial.id)
        : route('filters.store');

    form.post(formRoute, {
        onSuccess: () => {
            emit('success')
            toast.success(
                props.mode === 'edit' ? 'Filter updated with success!' : 'Filter created with success!',
                { position: 'top-center' }
            )
        },
        onError: (errors) => {
            console.log(errors)
            toast.error('Failed to save filter. Please try again.', {
                position: 'top-center',
            })
        }
    });
}
</script>

<template>
    <form @submit.prevent="submit" class="space-y-4" autocomplete="off">
        <div class="flex flex-col gap-4">
            <div>
                <Label for="brand" class="mb-2">Brand</Label>
                <Input id="brand" class="mt-1 block w-full" v-model="form.brand"
                    placeholder="e.g. Hario, Melitta, Chemex" required />
                <InputError :message="form.errors.brand" />
            </div>
            <div>
                <Label for="name" class="mb-2">Model Name</Label>
                <Input id="name" class="mt-1 block w-full" v-model="form.name" placeholder="e.g. V60, Kalita Wave" required />
                <InputError :message="form.errors.name" />
            </div>
            <div>
                <Label for="quantity" class="mb-2">Quantity</Label>
                <Input id="quantity" type="number" min="1" class="mt-1 block w-full" v-model="form.quantity" placeholder="e.g. 100" required />
                <InputError :message="form.errors.quantity" />
            </div>
            <div>
                <Label for="description" class="mb-2">Description</Label>
                <Input id="description" class="mt-1 block w-full" v-model="form.description" placeholder="Optional description" />
                <InputError :message="form.errors.description" />
            </div>
        </div>
        <div class="flex items-center gap-4">
            <Button :disabled="form.processing">
                <span v-if="form.processing">Saving...</span>
                <span v-else>Save</span>
            </Button>
        </div>
    </form>
</template> 