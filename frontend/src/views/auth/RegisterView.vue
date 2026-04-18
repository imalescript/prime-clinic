<script setup>
import { ref, computed } from 'vue';
import { useRouter } from 'vue-router';
import axios from '@/api/axios';

const router = useRouter();

const name = ref('');
const email = ref('');
const password = ref('');
const confirmPassword = ref('');

const errors = ref({});
const loading = ref(false);

const isValidEmail = (email) => {
    const pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return pattern.test(email);
};

const handleRegister = async () => {
    errors.value = {}; 

    if (!name.value) errors.value.name = "El nombre es obligatorio.";
    if (!email.value || !isValidEmail(email.value)) errors.value.email = "Correo no válido.";
    if (password.value.length < 8) errors.value.password = "Mínimo 8 caracteres.";
    if (password.value !== confirmPassword.value) errors.value.confirmPassword = "Las contraseñas no coinciden.";

    if (Object.keys(errors.value).length > 0) return;

    loading.value = true;

    try {
        await axios.get('/sanctum/csrf-cookie');

        const response = await axios.post('/register', {
            name: name.value,
            email: email.value,
            password: password.value,
            password_confirmation: confirmPassword.value
        });

        console.log("Usuario registrado con éxito");
        router.push('/dashboard'); 

    } catch (error) {
        if (error.response.status === 422) {
            errors.value = error.response.data.errors;
        }
    } finally {
        loading.value = false;
    }
};

const goToLogin = () => {
    router.push('/');
};
</script>

<template>
    <form @submit.prevent="handleRegister">
        <Card class="w-full overflow-hidden shadow-2xl">
            <template #title>
                <h1 class="text-center text-2xl font-bold mb-2">Crear Cuenta</h1>
            </template>
            
            <template #subtitle>
                <div class="text-center mb-4">Completa tus datos para registrarte</div>
            </template>

            <template #content>
                <div class="flex flex-col gap-4">
                    <div class="flex flex-col gap-2">
                        <label for="name" class="font-semibold">Nombre Completo</label>
                        <InputText id="name" v-model="name" :invalid="!!errors.name" placeholder="Juan Pérez" fluid />
                        <small class="text-red-500" v-if="errors.name">{{ errors.name }}</small>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="email" class="font-semibold">Correo Electrónico</label>
                        <InputText id="email" v-model="email" type="email" :invalid="!!errors.email" placeholder="ejemplo@correo.com" fluid />
                        <small class="text-red-500" v-if="errors.email">{{ errors.email }}</small>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="password" class="font-semibold">Contraseña</label>
                        <Password id="password" v-model="password" toggleMask :invalid="!!errors.password" fluid placeholder="********" 
                                  promptLabel="Elige una clave" weakLabel="Débil" mediumLabel="Media" strongLabel="Fuerte" />
                                  <small class="text-red-500" v-if="errors.password">{{ errors.password }}</small>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="confirmPassword" class="font-semibold">Confirmar Contraseña</label>
                        <Password id="confirmPassword" v-model="confirmPassword" :invalid="!!errors.confirmPassword" :feedback="false" toggleMask fluid placeholder="********" />
                        <small class="text-red-500" v-if="errors.confirmPassword">{{ errors.confirmPassword }}</small>
                    </div>
                </div>
            </template>

            <template #footer>
                <div class="flex flex-col gap-3 mt-2">
                    <Button type="submit" label="Crear Cuenta" icon="pi pi-user-plus" class="w-full" />
                    
                    <div class="flex items-center justify-center gap-2 mt-2">
                        <span class="text-sm text-color-secondary">¿Ya tienes cuenta?</span>
                        <Button label="Inicie sesión" link @click="goToLogin" class="p-0 text-sm font-bold" />
                    </div>
                </div>
            </template>
        </Card>
    </form>
</template>