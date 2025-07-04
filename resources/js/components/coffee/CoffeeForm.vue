'
<script setup lang="ts">
import { Brand, Coffee, RoastLevel } from '@/types';
import { useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import InputError from '@/components/InputError.vue';
import { toast } from 'vue-sonner';
import { ref, watch } from 'vue';
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectLabel,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select'
import { Textarea } from '../ui/textarea';

interface Props {
    method: 'post' | 'patch'
    action: string
    initial: Partial<Coffee>
    roastLevels: RoastLevel[]
    brands: Brand[]
}
const props = defineProps<Props>()

const form = useForm<{
    name: string;
    description?: string;
    sensory?: string;
    farm?: string;
    variety?: string;
    region?: string;
    altitude?: number;
    producer?: string;
    processing_method?: string;
    roaster?: string;
    brand_id: number;
    image?: string | File;
    roast_level_id: number;
}>({
    name: props.initial.name ?? '',
    description: props.initial.description ?? '',
    sensory: props.initial.sensory ?? '',
    farm: props.initial.farm ?? '',
    variety: props.initial.variety ?? '',
    region: props.initial.region ?? '',
    altitude: props.initial.altitude ?? 0,
    producer: props.initial.producer ?? '',
    processing_method: props.initial.processing_method ?? '',
    roaster: props.initial.roaster ?? '',
    brand_id: props.initial.brand_id ?? 0,
    image: props.initial.image ?? '',
    roast_level_id: props.initial.roast_level_id ?? 0,
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
        ? route('coffees.update', props.initial.id)
        : route('coffees.store');

    form.post(formRoute, {
        onSuccess: () => {
            emit('success')
            toast.success(
                isEditing ? 'Coffee updated with success!' : 'Coffee created with success!',
                { position: 'top-center' }
            )
        },
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
    (props.initial.image_url && typeof props.initial.image_url === 'string')
        ? props.initial.image_url
        : (typeof props.initial.image === 'string' && props.initial.image ? props.initial.image : null)
);

watch(
    () => form.image,
    (newImage) => {
        if (newImage && typeof newImage !== 'string') {
            // Preview para arquivo novo
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
    <form @submit.prevent="submit" class="space-y-6" autocomplete="off">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Coluna da imagem (1/3) -->
            <div>
                <div v-if="imagePreview" class="my-4 flex justify-center">
                    <img :src="imagePreview" alt="Current Photo" class="max-h-32 md:max-h-40 lg:max-h-48 rounded" />
                </div>
                <Label for="logo" class="mb-2">Coffee Photo</Label>
                <Input id="logo" type="file" accept="image/*" class="mt-1 block w-full" @change="onFileChange" />
                <InputError :message="form.errors.image" />
            </div>
            <!-- Coluna dos campos (2/3) -->
            <div class="md:col-span-2 space-y-6">
                <!-- Primeira linha: nome e marca -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <Label for="name" class="mb-2">Name</Label>
                        <Input id="name" class="mt-1 block w-full" v-model="form.name" required />
                        <InputError :message="form.errors.name" />
                    </div>
                    <div>
                        <Label for="brand" class="mb-2">Brand</Label>
                        <Select v-model="form.brand_id">
                            <SelectTrigger class="w-full">
                                <SelectValue placeholder="Select the brand" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectGroup>
                                    <SelectLabel>Brands</SelectLabel>
                                    <SelectItem v-for="brand in props.brands" :key="brand.id" :value="brand.id">
                                        {{ brand.name }}
                                    </SelectItem>
                                </SelectGroup>
                            </SelectContent>
                        </Select>
                        <InputError :message="form.errors.brand_id" />
                    </div>
                </div>

                <!-- Segunda linha: roast level e roaster -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <Label for="roast_level" class="mb-2">Roast Level</Label>
                        <Select v-model="form.roast_level_id">
                            <SelectTrigger class="w-full">
                                <SelectValue placeholder="Select the roast level" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectGroup>
                                    <SelectLabel>Roast Levels</SelectLabel>
                                    <SelectItem v-for="roastLevel in props.roastLevels" :key="roastLevel.id"
                                        :value="roastLevel.id">
                                        {{ roastLevel.name }}
                                    </SelectItem>
                                </SelectGroup>
                            </SelectContent>
                        </Select>
                        <InputError :message="form.errors.roast_level_id" />
                    </div>
                    <div>
                        <Label for="roaster" class="mb-2">Roaster</Label>
                        <Input id="roaster" class="mt-1 block w-full" v-model="form.roaster" />
                        <InputError :message="form.errors.roaster" />
                    </div>
                </div>

                <!-- Terceira linha: farm e variety -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <Label for="farm" class="mb-2">Farm</Label>
                        <Input id="farm" class="mt-1 block w-full" v-model="form.farm" />
                        <InputError :message="form.errors.farm" />
                    </div>
                    <div>
                        <Label for="variety" class="mb-2">Variety</Label>
                        <Input id="variety" class="mt-1 block w-full" v-model="form.variety" />
                        <InputError :message="form.errors.variety" />
                    </div>
                </div>

                <!-- Quarta linha: region e altitude -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <Label for="region" class="mb-2">Region</Label>
                        <Input id="region" class="mt-1 block w-full" v-model="form.region" />
                        <InputError :message="form.errors.region" />
                    </div>
                    <div>
                        <Label for="altitude" class="mb-2">Altitude (m)</Label>
                        <Input id="altitude" :min="0" type="number" class="mt-1 block w-full"
                            v-model.number="form.altitude" />
                        <InputError :message="form.errors.altitude" />
                    </div>
                </div>

                <!-- Quinta linha: producer e processing method -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <Label for="producer" class="mb-2">Producer</Label>
                        <Input id="producer" class="mt-1 block w-full" v-model="form.producer" />
                        <InputError :message="form.errors.producer" />
                    </div>
                    <div>
                        <Label for="processing_method" class="mb-2">Processing Method</Label>
                        <Input id="processing_method" class="mt-1 block w-full" v-model="form.processing_method" />
                        <InputError :message="form.errors.processing_method" />
                    </div>
                </div>

                <!-- Campos de texto longos em linha única -->
                <div>
                    <Label for="description" class="mb-2">Description</Label>
                    <Textarea id="description" class="mt-1 block w-full" v-model="form.description" />
                    <InputError :message="form.errors.description" />
                </div>
                <div>
                    <Label for="sensory" class="mb-2">Sensory Notes</Label>
                    <Textarea id="sensory" class="mt-1 block w-full" v-model="form.sensory" />
                    <InputError :message="form.errors.sensory" />
                </div>

                <!-- Botão -->
                <div class="flex items-center gap-4">
                    <Button :disabled="form.processing">
                        <span v-if="form.processing">Saving...</span>
                        <span v-else>Save</span>
                    </Button>
                </div>
            </div>
        </div>
    </form>
</template>