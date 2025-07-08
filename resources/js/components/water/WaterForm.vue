<script setup lang="ts">
import { Water } from '@/types';
import { useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import InputError from '@/components/InputError.vue';
import { watch, computed } from 'vue';

interface Props {
    mode: 'create' | 'edit';
    initial: Partial<Water>;
}
const props = defineProps<Props>();

const form = useForm<{
    name: string;
    chlorine?: number | null;
    calcium: number;
    magnesium: number;
    total_dissolved_solids?: number | null;
    hardness?: number | null;
    bicarbonate: number;
    alkalinity?: number | null;
    ph?: number | null;
    sodium?: number | null;
}>({
    name: props.initial.name ?? '',
    chlorine: props.initial.chlorine ?? null,
    calcium: props.initial.calcium ?? 0,
    magnesium: props.initial.magnesium ?? 0,
    total_dissolved_solids: props.initial.total_dissolved_solids ?? null,
    hardness: props.initial.hardness ?? null,
    bicarbonate: props.initial.bicarbonate ?? 0,
    alkalinity: props.initial.alkalinity ?? null,
    ph: props.initial.ph ?? null,
    sodium: props.initial.sodium ?? null,
});

const emit = defineEmits<{ (e: 'success'): void }>();

// Auto-calculate hardness and alkalinity
watch([
    () => form.calcium,
    () => form.magnesium,
    () => form.bicarbonate
], () => {
    form.hardness = (form.calcium * 2.5) + (form.magnesium * 4.2);
    form.alkalinity = form.bicarbonate * 0.8;
});

form.transform((data) => ({
    ...data,
    _method: props.mode === 'edit' ? 'patch' : 'post',
}));

const submit = () => {
    const formRoute = props.mode === 'edit'
        ? route('waters.update', props.initial.id)
        : route('waters.store');
    form.post(formRoute, {
        onSuccess: () => {
            emit('success');
        },
    });
};

// Computed properties for nullable fields to handle v-model binding
const chlorineModel = computed({
    get: () => form.chlorine ?? '',
    set: v => form.chlorine = v === '' ? null : Number(v)
});
const tdsModel = computed({
    get: () => form.total_dissolved_solids ?? '',
    set: v => form.total_dissolved_solids = v === '' ? null : Number(v)
});
const phModel = computed({
    get: () => form.ph ?? '',
    set: v => form.ph = v === '' ? null : Number(v)
});
const sodiumModel = computed({
    get: () => form.sodium ?? '',
    set: v => form.sodium = v === '' ? null : Number(v)
});
const hardnessModel = computed({
    get: () => form.hardness ?? '',
    set: v => form.hardness = v === '' ? null : Number(v)
});
const alkalinityModel = computed({
    get: () => form.alkalinity ?? '',
    set: v => form.alkalinity = v === '' ? null : Number(v)
});
</script>
<template>
    <form @submit.prevent="submit" class="space-y-6" autocomplete="off">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="space-y-2">
                <Label for="name">Name</Label>
                <Input id="name" v-model="form.name" type="text" />
                <InputError :message="form.errors.name" />

                <Label for="chlorine">Chlorine (mg/L)</Label>
                <Input id="chlorine" v-model.number="chlorineModel" type="number" step="0.01" />
                <InputError :message="form.errors.chlorine" />

                <Label for="calcium">Calcium (mg/L)</Label>
                <Input id="calcium" v-model.number="form.calcium" type="number" step="0.01" />
                <InputError :message="form.errors.calcium" />

                <Label for="magnesium">Magnesium (mg/L)</Label>
                <Input id="magnesium" v-model.number="form.magnesium" type="number" step="0.01" />
                <InputError :message="form.errors.magnesium" />

                <Label for="bicarbonate">Bicarbonate (mg/L)</Label>
                <Input id="bicarbonate" v-model.number="form.bicarbonate" type="number" step="0.01" />
                <InputError :message="form.errors.bicarbonate" />
            </div>
            <div class="space-y-2">
                <Label for="total_dissolved_solids">Total Dissolved Solids (mg/L)</Label>
                <Input id="total_dissolved_solids" v-model.number="tdsModel" type="number" step="0.01" />
                <InputError :message="form.errors.total_dissolved_solids" />

                <Label for="ph">pH</Label>
                <Input id="ph" v-model.number="phModel" type="number" step="0.01" />
                <InputError :message="form.errors.ph" />

                <Label for="sodium">Sodium (mg/L)</Label>
                <Input id="sodium" v-model.number="sodiumModel" type="number" step="0.01" />
                <InputError :message="form.errors.sodium" />

                <Label for="hardness">Hardness (mg/L)</Label>
                <Input id="hardness" v-model="hardnessModel" type="number" step="0.01" readonly />
                <InputError :message="form.errors.hardness" />

                <Label for="alkalinity">Alkalinity (mg/L)</Label>
                <Input id="alkalinity" v-model="alkalinityModel" type="number" step="0.01" readonly />
                <InputError :message="form.errors.alkalinity" />
            </div>
        </div>
        <div class="">
            <Button type="submit">{{ props.mode === 'edit' ? 'Update Water' : 'Create Water' }}</Button>
        </div>
    </form>
</template> 