<script setup lang="ts">
import { Brand } from '@/types';
import { useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import InputError from '@/components/InputError.vue';
import { toast } from 'vue-sonner';

interface Props {
    method: 'post' | 'patch'
    action: string
    initial: Partial<Brand>
}
const props = defineProps<Props>()

const form = useForm<{
    name: string;
    url: string;
    logo: string | File;
}>({
    name: props.initial.name ?? '',
    url: props.initial.url ?? '',
    logo: props.initial.logo ?? '',
});

const emit = defineEmits<{
    (e: 'success'): void
}>()

const submit = () => {
    const isEditing = 'id' in props.initial;
    const formRoute = isEditing && props.method === 'patch'
        ? route('brands.update', props.initial.id)
        : route('brands.store');

    form[props.method](formRoute, {
        onSuccess: () => {
            emit('success')
            toast.success(
                isEditing ? 'Brand updated with success!' : 'Brand created with success!',
                { position: 'top-center' }
            )
        },
    });
}

const onFileChange = (event: Event) => {
    const target = event.target as HTMLInputElement;
    if (target.files && target.files.length > 0) {
        form.logo = target.files[0];
    } else {
        form.logo = '';
    }
};

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
                <Label for="url" class="mb-2">URL</Label>
                <Input id="url" type="url" class="mt-1 block w-full" v-model="form.url" required />
                <InputError :message="form.errors.url" />
            </div>
            <div>
                <Label for="logo" class="mb-2">Logo</Label>
                <Input id="logo" type="file" accept="image/*" class="mt-1 block w-full" @change="onFileChange" />
                <InputError :message="form.errors.logo" />
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