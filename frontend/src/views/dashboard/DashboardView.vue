<script setup>
import { usePatientStore } from '@/stores/patientStore';
import { ref, onMounted } from 'vue';
import { FilterMatchMode } from '@primevue/core/api';

const patientStore = usePatientStore();
onMounted(() => {
    patientStore.fetchPatients();
});

//FILTER
const filters = ref({
    global: { value: null, matchMode: FilterMatchMode.CONTAINS },
});

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
          @click="" 
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
                <div class="flex gap-1.5">
                    <Button icon="pi pi-eye" rounded severity="info"/>
                    <Button icon="pi pi-pencil" rounded />
                    <Button icon="pi pi-trash" rounded  severity="danger"/>
                </div>
            </template>
        </Column>
    </DataTable>
</template>