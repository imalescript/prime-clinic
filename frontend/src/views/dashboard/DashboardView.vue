<script setup>
 import { usePatientStore } from '@/stores/patientStore';
 import { onMounted } from 'vue';

const patientStore = usePatientStore();

onMounted(() => {
    patientStore.fetchPatients();
});
</script>
<template>
    <DataTable
        scrollable 
        scrollHeight="flex" 
        scrollDirection="both"
        :value="patientStore.patients"
        :loading="patientStore.isLoading"
    >
        <Column 
            field="cedula" 
            header="Cédula"
            headerClass="min-w-32"
        ></Column>

        <Column 
            field="full_name" 
            header="Nombre"
            headerClass="min-w-48"
            frozen
        ></Column>

        <Column 
            field="age" 
            header="Edad"
            headerClass="min-w-16"
        ></Column>

        <Column 
            field="gender" 
            header="Género"
            headerClass="min-w-32"
        ></Column>

        <Column 
            field="phone" 
            header="Teléfono"
            headerClass="min-w-48"
        ></Column>

        <Column 
            field="blood_type" 
            header="Sangre"
            headerClass="min-w-16"
            ></Column>
        <Column 
            field="" 
            header="Email"
            headerClass="min-w-48"
        ></Column>

        <Column 
            field="" 
            header="Dirección"
            headerClass="min-w-48"
        ></Column>

        <Column 
            field="" 
            header="Condiciones"
            headerClass="min-w-64"
        ></Column>
    </DataTable>
</template>