<script setup>
import { reactive, ref } from 'vue';
import { useRouter } from 'vue-router';
import { useAuthStore } from '@/stores/auth';
import { onUnmounted } from 'vue';

const router = useRouter();
const authStore = useAuthStore();
const localErrors = ref({});

const form = reactive({
    name: '',
    email: '',
    password: '',
    password_confirmation: ''
});

const isValidEmail = (email) => {
    const pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return pattern.test(email);
};

const submitRegister = () => {
    localErrors.value = {};
    
    if (!form.name || form.name.length <3) localErrors.value.name = "El nombre es obligatorio y debe tener al menos tres carácteres.";
    if (!form.email || !isValidEmail(form.email)) localErrors.value.email = "Correo no válido.";
    if (form.password.length < 8) localErrors.value.password = "Mínimo 8 caracteres.";
    if (form.password !== form.password_confirmation) localErrors.value.password_confirmation = "Las contraseñas no coinciden.";
    if (Object.keys(localErrors.value).length > 0) return;
    
    authStore.handleRegister(form);
};

const goToLogin = () => {
    router.push('/');
};

onUnmounted(() => {
    authStore.authErrors = {};
    localErrors.value = {}; 
});
</script>

<template>
    <form @submit.prevent="submitRegister">
        <Card class="w-full overflow-hidden shadow-2xl bg-surface-50">
            <template #title>
                <h1 class="text-center text-2xl font-bold mb-2">Crear Cuenta</h1>
            </template>
            
            <template #subtitle>
                <div class="text-center mb-4">Completa tus datos para registrarte</div>
            </template>

            <template #content>
                <div class="flex flex-col gap-4">
                    <div class="flex flex-col gap-2">
                        <label for="name-register" class="font-semibold">Nombre Completo</label>
                        <InputText
                        id="name-register"
                        v-model="form.name"
                        :invalid="!!(localErrors.name || authStore.authErrors.name)"
                        placeholder="Juan Pérez"
                        fluid />
                        <small class="text-red-500" v-if="localErrors.name || authStore.authErrors.name">
                            {{ localErrors.name || authStore.authErrors.name[0] }}
                        </small>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="email-register" class="font-semibold">Correo Electrónico</label>
                        <InputText 
                        id="email-register"
                        v-model="form.email" 
                        type="email" 
                        :invalid="!!(localErrors.email || authStore.authErrors.email)" 
                        placeholder="ejemplo@correo.com" 
                        fluid />
                        <small class="text-red-500" v-if="localErrors.email || authStore.authErrors.email">
                            {{ localErrors.email || authStore.authErrors.email[0] }}
                        </small>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="pass-register" class="font-semibold">Contraseña</label>
                        <Password 
                        :inputProps="{ id: 'pass-register' }"
                        v-model="form.password" 
                        :invalid="!!(localErrors.password || authStore.authErrors.password)" 
                        toggleMask 
                        fluid 
                        placeholder="********" 
                        promptLabel="Elige una clave" weakLabel="Débil" mediumLabel="Media" strongLabel="Fuerte" />
                        <small class="text-red-500" v-if="localErrors.password || authStore.authErrors.password">
                            {{ localErrors.password || authStore.authErrors.password[0] }}
                        </small>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="confirmPass-register" class="font-semibold">Confirmar Contraseña</label>
                        <Password 
                        :inputProps="{ id: 'confirmPass-register'}"
                        v-model="form.password_confirmation" 
                        :invalid="!!(localErrors.password_confirmation || authStore.authErrors.password_confirmation)" 
                        toggleMask 
                        fluid 
                        placeholder="********" />
                        <small class="text-red-500" v-if="localErrors.confirmPassword || authStore.authErrors.password_confirmation">
                            {{ localErrors.password_confirmation || authStore.authErrors.password_confirmation[0] }}
                        </small>
                    </div>
                </div>
            </template>

            <template #footer>
                <div class="flex flex-col gap-3 mt-2">
                    <Button 
                    type="submit"
                    label="Crear Cuenta" 
                    :loading="authStore.isLoading"
                    class="w-full" />
                    
                    <div class="center-box gap-2 mt-2">
                        <span class="text-color-secondary">¿Ya tienes cuenta?</span>

                        <Button label="Inicie sesión" class="p-0 text-sm font-bold" link @click="goToLogin" />
                    </div>
                </div>
            </template>
        </Card>
    </form>
</template>