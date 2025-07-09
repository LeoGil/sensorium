<script setup lang="ts">
import { BrewingMethod } from '@/types';
import { useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import InputError from '@/components/InputError.vue';
import { toast } from 'vue-sonner';
import { ref, watch } from 'vue';

interface Props {
    mode: 'create' | 'edit'
    initial: Partial<BrewingMethod>
}
const props = defineProps<Props>()

const form = useForm<{
    name: string;
    image?: string | File;
}>({
    name: props.initial.name ?? '',
    image: props.initial.image ?? '',
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
        ? route('brewing-methods.update', props.initial.id)
        : route('brewing-methods.store');

    if (typeof form.image === 'string') {
        delete form.image;
    }

    form.post(formRoute, {
        onSuccess: () => {
            emit('success')
            toast.success(
                props.mode === 'edit' ? 'Brewing method updated with success!' : 'Brewing method created with success!',
                { position: 'top-center' }
            )
        },
        onError: (errors) => {
            console.log(errors)
            toast.error('Failed to save brewing method. Please try again.', {
                position: 'top-center',
            })
        }
    });
}

const onFileChange = (event: Event) => {
    const target = event.target as HTMLInputElement;
    if (target.files && target.files.length > 0) {
        form.image = target.files[0];
    } else {
        form.image = '';
    }
};

const imagePreview = ref<string | null>(
    typeof props.initial.image_url === 'string' && props.initial.image_url ? props.initial.image_url : null
);

watch(
    () => form.image,
    (newImage) => {
        if (newImage && typeof newImage !== 'string') {
            imagePreview.value = URL.createObjectURL(newImage as File);
        } else if (typeof newImage === 'string' && newImage) {
            imagePreview.value = newImage;
        } else if (props.initial.image_url) {
            imagePreview.value = props.initial.image_url;
        } else {
            imagePreview.value = null;
        }
    }
);
</script>

<template>
    <form @submit.prevent="submit" class="space-y-4" autocomplete="off">
        <div class="flex flex-col gap-4">
            <div>
                <Label for="name" class="mb-2">Name</Label>
                <Input id="name" class="mt-1 block w-full" v-model="form.name"
                    placeholder="e.g. Gaggia Classic, V60, etc." required />
                <InputError :message="form.errors.name" />
            </div>
            <div>
                <div v-if="imagePreview" class="my-4 flex justify-center">
                    <img :src="imagePreview" alt="Current Photo" class="max-h-32 md:max-h-40 lg:max-h-48 rounded" />
                </div>
                <Label for="logo" class="mb-2">Brewing Method Photo</Label>
                <Input id="logo" type="file" accept="image/*" class="mt-1 block w-full" @change="onFileChange" />
                <InputError :message="form.errors.image" />
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