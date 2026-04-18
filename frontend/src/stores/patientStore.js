import { defineStore } from 'pinia';
import { ref } from 'vue';
import axiosInstance from '@/api/axios'; // Asumiendo tu ruta de axios

export const usePatientStore = defineStore('patient', () => {
    const patients = ref([]);          
    const currentPatient = ref(null);  
    const isLoading = ref(false);      
    const patientErrors = ref({});            


    const fetchPatients = async () => {
        isLoading.value = true;
        patientErrors.value = {};
        try {
            const response = await axiosInstance.get('/api/patients');
            // IMPORTANTE: Asegúrate de mapear según la estructura de tu JSON
            patients.value = response.data.data || response.data; 
        } catch (error) {
            console.error("Error al cargar pacientes:", error);
            patientErrors.value = error.response?.data?.errors || { message: "Error de red" };
        } finally {
            isLoading.value = false;
        }
    };

    // 2. Crear un nuevo paciente
    const storePatient = async (data) => {
        isLoading.value = true;
        patientErrors.value = {};
        try {
            await axiosInstance.post('/api/patients', data);
            await fetchPatients();
            return true;
        } catch (error) {
            if (error.response?.status === 422) {
                patientErrors.value = error.response.data.errors;
            }
            return false;
        } finally {
            isLoading.value = false;
        }
    };

    const resetStore = () => {
        patients.value = [];
        currentPatient.value = null;
        patientErrors.value = {};
    };

    return {
        patients,
        currentPatient,
        isLoading,
        patientErrors,
        fetchPatients,
        storePatient,
        resetStore
    };
});