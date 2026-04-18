<script setup>
import { reactive, ref } from 'vue';
import { useRouter } from 'vue-router';
import { useAuthStore } from '@/stores/auth';
import { onUnmounted } from 'vue';

const router = useRouter();
const authStore = useAuthStore();
const localErrors = ref({});

const form = reactive({
    email: '',
    password: ''
});

const isValidEmail = (value) => {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
};

const sumbitLogin = () => {
    localErrors.value = {};
    
    if (!form.email) {
        localErrors.value.email = "El correo es obligatorio.";
    } else if (!isValidEmail(form.email)) {
        localErrors.value.email = "Ingresa un correo válido.";
    }
    if (!form.password) {
        localErrors.value.password = "La contraseña es obligatoria.";
    }
    if (Object.keys(localErrors.value).length > 0) return;
    
    authStore.handleLogin(form);
};

const goToRegister = () => {
    router.push('/register');
};

onUnmounted(() => {
    authStore.authErrors = {};
    localErrors.value = {}; 
});
</script>

<template>
    <form @submit.prevent="sumbitLogin" class="flex flex-col gap-4">
        <Card class="w-full overflow-hidden shadow-2xl bg-surface-50">
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
                        v-model="form.email" 
                        type="email" 
                        :invalid="!!(localErrors.email || authStore.authErrors.email)"
                        placeholder="ejemplo@correo.com" fluid />
                        <small class="text-red-500" v-if="localErrors.email || authStore.authErrors.email">
                            {{ localErrors.email || authStore.authErrors.email }}
                        </small>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="pass-login" class="font-semibold">Contraseña</label>
                        <Password 
                        :inputProps="{ id: 'pass-login' }"
                        v-model="form.password" 
                        toggleMask fluid 
                        :invalid="!!(localErrors.password || authStore.authErrors.password)" 
                        placeholder="********" />
                        <small class="text-red-500" v-if="localErrors.password || authStore.authErrors.password">
                            {{ localErrors.password || authStore.authErrors.password }}
                        </small>
                    </div>

                    <div class="flex justify-end">
                        <Button label="¿Ha olvidado la contraseña?" link class="text-sm" />
                    </div>
                </div>

                <Button 
                type="submit" 
                label="Entrar" 
                :loading="authStore.isLoading"
                class="w-full" />
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