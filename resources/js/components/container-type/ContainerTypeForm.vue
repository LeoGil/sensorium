<script setup lang="ts">
import { ContainerType } from '@/types';
import { useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import InputError from '@/components/InputError.vue';
import { toast } from 'vue-sonner';
import { computed } from 'vue';

interface Props {
    mode: 'create' | 'edit'
    initial: Partial<ContainerType>
}
const props = defineProps<Props>()

const form = useForm<{
    name: string;
    capacity: number | null;
}>({
    name: props.initial.name ?? '',
    capacity: props.initial.capacity ?? null,
});

const emit = defineEmits<{
    (e: 'success'): void
}>()

form.transform((data) => ({
    ...data,
    _method: props.mode === 'edit' ? 'patch' : 'post',
}));

const capacityValue = computed({
    get: () => form.capacity ?? '',
    set: (val: string | number) => {
        form.capacity = val === '' ? null : Number(val);
    }
});

const submit = () => {
    const formRoute = props.mode === 'edit'
        ? route('container-types.update', props.initial.id)
        : route('container-types.store');

    form.post(formRoute, {
        onSuccess: () => {
            emit('success')
            toast.success(
                props.mode === 'edit' ? 'Container updated with success!' : 'Container created with success!',
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
                <Label for="capacity" class="mb-2">Capacity <span class="text-xs text-gray-500">(in grams)</span></Label>
                <Input id="capacity" type="number" step="any" class="mt-1 block w-full" v-model="capacityValue" required />
                <InputError :message="form.errors.capacity" />
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