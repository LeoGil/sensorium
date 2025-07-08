<script setup lang="ts">
import { Brand } from '@/types';
import { useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import InputError from '@/components/InputError.vue';
import { toast } from 'vue-sonner';
import { ref, watch } from 'vue';

interface Props {
    mode: 'create' | 'edit'
    initial: Partial<Brand>
}
const props = defineProps<Props>()

const form = useForm<{
    name: string;
    url: string;
    logo?: string | File;
}>({
    name: props.initial.name ?? '',
    url: props.initial.url ?? '',
    logo: '',
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
        ? route('brands.update', props.initial.id)
        : route('brands.store');

    form.post(formRoute, {
        onSuccess: () => {
            emit('success')
            toast.success(
                props.mode === 'edit' ? 'Brand updated with success!' : 'Brand created with success!',
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

const logoPreview = ref<string | null>(
    typeof props.initial.logo === 'string' && props.initial.logo ? props.initial.logo : null
);

watch(
    () => form.logo,
    (newLogo) => {
        if (newLogo && typeof newLogo !== 'string') {
            // Show preview for newly selected file
            logoPreview.value = URL.createObjectURL(newLogo as File);
        } else if (typeof newLogo === 'string' && newLogo) {
            logoPreview.value = newLogo;
        } else {
            logoPreview.value = null;
        }
    }
);

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
                <Input id="url" type="url" class="mt-1 block w-full" v-model="form.url" />
                <InputError :message="form.errors.url" />
            </div>
            <div>
                <Label for="logo" class="mb-2">Logo</Label>
                <div v-if="logoPreview" class="my-4 flex justify-center">
                    <img :src="logoPreview" alt="Current Logo" class="max-h-24 rounded" />
                </div>
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