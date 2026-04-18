<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import axiosInstance from '@/api/axios';

const router = useRouter();

const email = ref('');
const password = ref('');

const errors = ref({});
const loading = ref(false);

const isValidEmail = (value) => {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
};

const handleLogin = async () => {
    errors.value = {};
    
    if (!email.value) {
        errors.value.email = "El correo es obligatorio.";
    } else if (!isValidEmail(email.value)) {
        errors.value.email = "Ingresa un correo válido.";
    }
    if (!password.value) errors.value.password = "Mínimo 8 caracteres.";

    try {
        await axiosInstance.get('/sanctum/csrf-cookie');

        const response = await axiosInstance.post('/login', {
            email: email.value,
            password: password.value,
        });

        console.log("Usuario registrado con éxito");
        router.push('/dashboard'); 
    } catch (error) {
        if (error.response && error.response.status === 422) {
            throw error.response.data.errors;
        }
    }
};

const goToRegister = () => {
    router.push('/register');
};
</script>

<template>
    <form @submit.prevent="handleLogin" class="flex flex-col gap-4">
        <Card class="w-full overflow-hidden shadow-2xl"">
            <template #title>
                <h1 class="text-center text-2xl font-bold mb-2">Bienvenido</h1>
            </template>
            
            <template #subtitle>
                <div class="text-center mb-4">Inicia Sesión</div>
            </template>

            <template #content>
                <div class="flex flex-col gap-4">
                    <div class="flex flex-col gap-2">
                        <label for="email-login" class="font-semibold">Correo Electrónico</label>
                        <InputText 
                        id="email-login"
                        v-model="email" 
                        type="email" 
                        :invalid="!!errors.email" 
                        placeholder="ejemplo@correo.com" fluid />
                        <small class="text-red-500" v-if="errors.email">{{ errors.email }}</small>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="pass-login" class="font-semibold">Contraseña</label>
                        <Password 
                        :inputProps="{ id: 'pass-login' }"
                        v-model="password" 
                        toggleMask fluid 
                        :invalid="!!errors.password" 
                        placeholder="********" />
                        <small class="text-red-500" v-if="errors.password">{{ errors.password }}</small>
                    </div>

                    <div class="flex justify-end">
                        <Button label="¿Ha olvidado la contraseña?" link class="text-sm" />
                    </div>
                </div>

                <Button type="submit" label="Entrar" icon="pi pi-sign-in" class="w-full" />
            </template>

            <template #footer>
                <div class="flex flex-col gap-3 mt-2">
                    <span class="text-center">o</span>

                    <Button label="Crear cuenta" icon="pi pi-user-plus" severity="secondary" outlined @click="goToRegister" class="w-full" />
                </div>
            </template>
        </Card>
    </form>
</template>