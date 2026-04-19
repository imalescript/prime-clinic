<script setup>
import { onMounted, onUnmounted, ref, computed } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { usePatientStore } from '@/stores/patientStore';

const route = useRoute();
const router = useRouter();
const patientStore = usePatientStore();

const isEditing = ref(false);

const patient = computed(() => patientStore.currentPatient);

onMounted(async () => {
    const id = route.params.id;
    const success = await patientStore.fetchPatientById(id);
    
    if (!success) {
        console.error("Paciente no encontrado");
    }
});

onUnmounted(() => {
    patientStore.currentPatient = null;
});

const handleEdit = () => {
    const id = route.params.id; 
    router.push({ name: 'patients.update', params: { id } });
};

const visible = ref(false);
const selectedPatientId = ref(null); 
const openDialogDelete = () => {
    selectedPatientId.value = route.params.id; // Guardamos el ID del paciente "en espera"
};
const confirmDelete = async ()  => {
    if (!selectedPatientId.value) return;

    try {
        await patientStore.deletePatient(selectedPatientId.value);
        router.push({ name: 'dashboard'})
    } catch (error) {
        console.log(error)
    }
};
</script>

<template>
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
      
      <div class="flex items-center gap-4">
        <div class="h-16 w-16 bg-blue-100 text-blue-600 rounded-full center-box text-2xl font-bold">
          {{ patient?.first_name[0] }}{{ patient?.last_name[0] }}
        </div>

        <div>
          <h1 class="text-3xl font-bold text-gray-800">
            {{ patient?.full_name }}
          </h1>
          <p class="text-gray-500 mt-2">ID: {{ patient?.id }}</p>
        </div>
      </div>
      <!-- botones -->
      <div class="flex gap-2">
        <Button label="Volver" icon="pi pi-arrow-left" outlined @click="router.back()" />
        <Button label="Editar" icon="pi pi-pencil" @click="handleEdit" />
        <Button 
            label="Eliminar"
            icon="pi pi-trash"   
            severity="danger"
            @click="openDialogDelete(), visible=true" />
      </div>
    </div>
        <!-- cuadro de informacion critica       -->
      <div class="bg-amber-50 border-l-4 border-amber-500 p-4 mb-8">
        <div class="flex items-center gap-2 text-amber-800 font-bold mb-1">
          <i class="pi pi-exclamation-triangle"></i>
          <span>INFORMACIÓN MÉDICA CRÍTICA</span>
        </div>

        <p class="text-amber-700 text-sm">
          <strong>Alergias:</strong> {{ patient?.allergies || 'Ninguna' }} <br>
          <strong>Condiciones:</strong> {{ patient?.chronic_conditions || 'Ninguna' }}
        </p>
      </div>
      <!-- datos personales -->
      <div class="flex flex-wrap gap-6 mb-8">
        <div>
          <label class="text-xs font-semibold text-gray-400 uppercase">Cédula</label>
          <p class="text-gray-700">{{ patient?.cedula }}</p>
        </div>

        <div>
          <label class="text-xs font-semibold text-gray-400 uppercase">Género</label>
          <p class="text-gray-700">{{ patient?.gender }}</p>
        </div>

        <div>
          <label class="text-xs font-semibold text-gray-400 uppercase">Tipo de Sangre</label>
          <p class="text-red-600 font-bold">{{ patient?.blood_type }}</p>
        </div>

        <div>
          <label class="text-xs font-semibold text-gray-400 uppercase">F. Nacimiento</label>
          <p class="text-gray-700">{{ new Date(patient?.birth_date).toLocaleDateString() }}</p>
        </div>

         <div>
          <label class="text-xs font-semibold text-gray-400 uppercase">Dirección</label>
            <p class="text-gray-700">{{ patient?.address || 'No se ha registrado una dirección física.' }}</p>
        </div>
      </div>
      <!-- contacto -->
      <div class="space-y-4 flex gap-6 mb-8">
        <div class="flex items-start gap-3">
          <i class="pi pi-phone mt-1 text-blue-500"></i>
          <div>
            <p class="text-xs text-gray-400 uppercase font-bold">Teléfono</p>
            <p class="text-sm">{{ patient?.phone || 'Sin teléfono' }}</p>
          </div>
        </div>

        <div class="flex items-start gap-3">
          <i class="pi pi-envelope mt-1 text-blue-500"></i>
          <div>
            <p class="text-xs text-gray-400 uppercase font-bold">Correo Electrónico</p>
            <p class="text-sm truncate">{{ patient?.email || 'Sin correo' }}</p>
          </div>
        </div>
      </div>
      <!-- registro -->
        <p class="text-xs text-gray-400 uppercase font-bold mb-2">Registro de Sistema</p>
        <div class="flex items-center gap-2 text-sm text-gray-600">
          <i class="pi pi-user text-xs"></i>
          <span>Registrado por ID: {{ patient?.user_id }}</span>
        </div>

<Dialog v-model:visible="visible" modal header="Eliminar Paciente" :style="{ width: '25rem' }">
<span class="text-surface-500 dark:text-surface-400 block mb-8">¿Estás seguro?</span>

<div class="flex justify-end gap-2">
<Button type="button" label="Cancelar" severity="secondary" @click="visible = false"></Button>
<Button type="button" label="Eliminar" @click="confirmDelete(), visible = false"></Button>
</div>
</Dialog>
</template>