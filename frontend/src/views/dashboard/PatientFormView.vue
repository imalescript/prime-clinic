<script setup>
import { ref, onMounted, computed } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { usePatientStore } from '@/stores/patientStore';
import DatePicker from 'primevue/datepicker';
import Select from 'primevue/select';

const route = useRoute();
const router = useRouter();
const patientStore = usePatientStore();

const isEdit = computed(() => !!route.params.id);

const form = ref({
    cedula: '',
    first_name: '',
    last_name: '',
    birth_date: null,
    gender: null,
    email: '',
    phone: '',
    blood_type: null,
    address: '',
    allergies: '',
    chronic_conditions: ''
});

const genders = ref(['Masculino', 'Femenino', 'Otro']);
const bloodTypes = ref(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-']);

onMounted(async () => {
    if (isEdit.value) {
        const success = await patientStore.fetchPatientById(route.params.id);
        if (success && patientStore.currentPatient) {
            // datos existentes
            form.value = { ...patientStore.currentPatient };
            // si la fecha viene como string
            if (form.value.birth_date) {
                form.value.birth_date = new Date(form.value.birth_date);
            }
        }
    }
});

const handleSubmit = async () => {
    let success = false;
    
    if (isEdit.value) {
        success = await patientStore.updatePatient(route.params.id, form.value);
    } else {
        success = await patientStore.storePatient(form.value);
    }

    if (success) {
        router.push({ name: 'dashboard' });
    }
};
</script>

<template>
    <!-- titulo -->
     <div>
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">
                {{ isEdit ? 'Editar Paciente' : 'Nuevo Registro' }}
            </h1>
            <Button label="Cancelar" icon="pi pi-times" outlined severity="secondary" @click="router.back()" />
        </div>

        <form @submit.prevent="handleSubmit">
            <div class="grid grid-cols-3 gap-2">
                <div class="flex flex-col gap-1">
                    <label for="first_name" class="font-semibold">Nombres</label>
                    <InputText id="first_name" v-model="form.first_name" />
                    <small class="p-error">{{ patientStore.patientErrors.first_name?.[0] }}</small>
                </div>

                <div class="flex flex-col gap-1">
                    <label for="last_name" class="font-semibold">Apellidos</label>
                    <InputText id="last_name" v-model="form.last_name" />
                    <small class="p-error">{{ patientStore.patientErrors.last_name?.[0] }}</small>
                </div>

                <div class="flex flex-col gap-1">
                    <label for="cedula" class="font-semibold">Cédula</label>
                    <InputText id="cedula" v-model="form.cedula" :class="{'p-invalid': patientStore.patientErrors.cedula}" />
                    <small class="p-error">{{ patientStore.patientErrors.cedula?.[0] }}</small>
                </div>

                <div class="flex flex-col gap-1">
                    <label for="birth_date" class="font-semibold">Fecha de Nacimiento</label>
                    <DatePicker :inputProps="{ id: 'birth_date' }" v-model="form.birth_date" dateFormat="dd/mm/yy" />
                    <small class="p-error">{{ patientStore.patientErrors.birth_date?.[0] }}</small>
                </div>

                <div class="flex flex-col gap-1">
                    <label class="font-semibold">Género</label>
                    <Select v-model="form.gender" :options="genders" placeholder="Seleccione uno" />
                </div>

                <div class="flex flex-col gap-1">
                    <label class="font-semibold">Tipo de Sangre</label>
                    <Select v-model="form.blood_type" :options="bloodTypes" placeholder="Seleccione uno" />
                </div>
            </div>
            
            <div class="grid grid-cols-2 gap-2">
                <div class="flex flex-col gap-1">
                    <label class="font-semibold">Alergias</label>
                    <Textarea v-model="form.allergies" rows="2" autoResize />
                </div>

                <div class="flex flex-col gap-1">
                    <label class="font-semibold">Condiciones Crónicas</label>
                    <Textarea v-model="form.chronic_conditions" rows="2" autoResize />
                </div>
            </div>

            <div class="flex justify-end mt-4">
                <Button type="submit" 
                        :label="isEdit ? 'Actualizar' : 'Guardar'" 
                        icon="pi pi-check" 
                        :loading="patientStore.isLoading" />
            </div>
        </form>
    </div>
</template>