import { defineStore } from 'pinia';
import axios from 'axios';

export const usePatientStore = defineStore('patient', {
  state: () => ({
    patients: [],
    loading: false,
    error: null
  }),
  actions: {
    async fetchPatients() {
      this.loading = true;
      try {
        const response = await axios.get('https://tu-api.com/api/patients');
        this.patients = response.data;
      } catch (err) {
        this.error = 'Error al cargar los pacientes';
        console.error(err);
      } finally {
        this.loading = false;
      }
    }
  }
});