<script setup>
import { usePatientStore } from '@/stores/patientStore';
import { ref, onMounted } from 'vue';
import { FilterMatchMode } from '@primevue/core/api';
import { useRouter } from 'vue-router';

const router = useRouter();

const patientStore = usePatientStore();
onMounted(() => {
    patientStore.fetchPatients();
});

const filters = ref({
    global: { value: null, matchMode: FilterMatchMode.CONTAINS },
});

const createPatient = () => {
    router.push({ name: 'patients.store' });
};
const viewPatient = (id) => {
    router.push({ name: 'patients.show', params: { id } });
};
const editPatient = (id) => {
    router.push({ name: 'patients.update', params: { id } });
};

const visible = ref(false);
const selectedPatientId = ref(null); 
const openDialogDelete = (id) => {
    selectedPatientId.value = id; // Guardamos el ID del paciente "en espera"
};
const confirmDelete = async ()  => {
    if (!selectedPatientId.value) return;

    try {
        await patientStore.deletePatient(selectedPatientId.value);
        
    } catch (error) {
        console.log(error)
    }
};
</script>

<template>
    <DataTable
        sortMode="multiple" removableSort
        scrollable scrollHeight="flex" scrollDirection="both"
        paginator :rows="10" :rowsPerPageOptions="[10, 20, 30, 40]"
        :value="patientStore.patients"
        :loading="patientStore.isLoading"
        :filters="filters"
        :globalFilterFields="['cedula', 'full_name', 'phone']"
    >

    <template #header>
      <div class="flex flex-wrap items-center justify-between gap-4">
        
        <Button 
          icon="pi pi-plus" 
          rounded
          @click="createPatient" 
        />

        <IconField>
          <InputIcon class="pi pi-search" />
          <InputText
            id="filter-input"
            v-model="filters['global'].value" 
            placeholder="Buscar..." 
            class="w-full sm:w-64"
          />
        </IconField>

      </div>
    </template>

        <Column 
            sortable
            field="cedula" 
            header="Cédula"
            headerClass="min-w-32"
        ></Column>

        <Column 
            sortable
            field="full_name" 
            header="Nombre"
            headerClass="min-w-48"
            frozen
        ></Column>

        <Column 
            sortable
            field="age" 
            header="Edad"
            headerClass="min-w-16"
        ></Column>

        <Column 
            sortable
            field="gender" 
            header="Género"
            headerClass="min-w-32"
        ></Column>

        <Column 
            sortable
            field="phone" 
            header="Teléfono"
            headerClass="min-w-48"
        ></Column>

        <Column 
            sortable
            field="blood_type" 
            header="Sangre"
            headerClass="min-w-16"
        ></Column>
        
        <Column 
            sortable
            field="" 
            header="Email"
            headerClass="min-w-48"
        ></Column>

        <Column 
            sortable
            field="" 
            header="Dirección"
            headerClass="min-w-48"
        ></Column>

        <Column
        header="Acción"        
        header-class="min-w-48"
        >
            <template #body="slotProps">
                <div class="flex gap-2">
                    <Button 
                    icon="pi pi-eye" 
                    rounded severity="info" 
                    @click="viewPatient(slotProps.data.id)" />
                    <Button 
                    icon="pi pi-pencil"
                     rounded 
                     @click="editPatient(slotProps.data.id)"/>
                    <Button 
                    icon="pi pi-trash" 
                    rounded  
                    severity="danger"
                    @click="openDialogDelete(slotProps.data.id), visible=true" />
                </div>
            </template>
        </Column>
    </DataTable>

    <Dialog v-model:visible="visible" modal header="Eliminar Paciente" :style="{ width: '25rem' }">
    <span class="text-surface-500 dark:text-surface-400 block mb-8">¿Estás seguro?</span>

    <div class="flex justify-end gap-2">
        <Button type="button" label="Cancelar" severity="secondary" @click="visible = false"></Button>
        <Button type="button" label="Eliminar" @click="confirmDelete(), visible = false"></Button>
    </div>
    </Dialog>
</template>
