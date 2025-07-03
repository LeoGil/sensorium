<script setup lang="ts">
import { RoastLevel } from '@/types';
import { useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import InputError from '@/components/InputError.vue';
import { toast } from 'vue-sonner';
import { Textarea } from '../ui/textarea';

interface Props {
    method: 'post' | 'patch'
    action: string
    initial: Partial<RoastLevel>
}
const props = defineProps<Props>()

const form = useForm<{
    name: string;
    description: string;
}>({
    name: props.initial.name ?? '',
    description: props.initial.description ?? '',
});

const emit = defineEmits<{
    (e: 'success'): void
}>()

form.transform((data) => ({
    ...data,
    _method: props.method.toUpperCase(),
}));

const submit = () => {
    const isEditing = 'id' in props.initial;
    const formRoute = isEditing && props.method === 'patch'
        ? route('roast-levels.update', props.initial.id)
        : route('roast-levels.store');

    form.post(formRoute, {
        onSuccess: () => {
            emit('success')
            toast.success(
                isEditing ? 'Roast level updated with success!' : 'Roast level created with success!',
                { position: 'top-center' }
            )
        },
    });
}

</script>

<template>
    <form @submit.prevent="submit" class="space-y-4" autocomplete="off">
        <div class="flex flex-col gap-4">
            <div>
                <Label for="name" class="mb-2">Name</Label>
                <Input id="name" class="mt-1 block w-full" v-model="form.name" required />
                <InputError :message="form.errors.name" />
            </div>
            <div>
                <Label for="description" class="mb-2">Description</Label>
                <Textarea id="description" class="mt-1 block w-full" v-model="form.description" />
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