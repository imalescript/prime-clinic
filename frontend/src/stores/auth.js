import { defineStore } from 'pinia';
import { ref, computed } from 'vue';
import axiosInstance from '@/api/axios';
import { useRouter } from 'vue-router';

export const useAuthStore = defineStore('auth', () => {
    const router = useRouter();
    
    // -- Estado (State) --
    const authUser = ref(null);
    const authErrors = ref({});
    const isLoading = ref(false);

    // -- Getters --
    const isAuthenticated = computed(() => !!authUser.value);

    // -- Acciones (Actions) --
    
    // Obtener datos del usuario autenticado
    const getUser = async () => {
        try {
            const response = await axiosInstance.get('/api/user');
            authUser.value = response.data;
        } catch (error) {
            authUser.value = null;
        }
    };

    // Registro
    const handleRegister = async (data) => {
        authErrors.value = {};
        isLoading.value = true;
        try {
            await axiosInstance.get('/sanctum/csrf-cookie');
            await axiosInstance.post('/register', data);
            await getUser();
            router.push('/dashboard');
        } catch (error) {
            if (error.response?.status === 422) {
                authErrors.value = error.response.data.errors;
            }
        } finally {
            isLoading.value = false;
        }
    };

    // Login
    const handleLogin = async (data) => {
        authErrors.value = {};
        isLoading.value = true;
        try {
            await axiosInstance.get('/sanctum/csrf-cookie');
            await axiosInstance.post('/login', data);
            await getUser();
            router.push('/dashboard');
        } catch (error) {
            if (error.response?.status === 422) {
                authErrors.value = error.response.data.errors;
            }
        } finally {
            isLoading.value = false;
        }
    };

    return {
        authUser,
        authErrors,
        isLoading,
        isAuthenticated,
        handleRegister,
        handleLogin,
        getUser
    };
});