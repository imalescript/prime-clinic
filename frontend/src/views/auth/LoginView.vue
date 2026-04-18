<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter();

const email = ref('');
const password = ref('');

const errors = ref({});
const loading = ref(false);

const isValidEmail = (value) => {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
};

const handleLogin = () => {
    errors.value = {};

    if (!email.value) {
        errors.value.email = "El correo es obligatorio.";
    } else if (!isValidEmail(email.value)) {
        errors.value.email = "Ingresa un correo válido.";
    }

    if (!password.value) {
        errors.value.password = "La contraseña es obligatoria.";
    }

    if (Object.keys(errors.value).length === 0) {
        console.log("Intentando login con:", { email: email.value, password: password.value });
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
                        <label for="email" class="font-semibold">Correo Electrónico</label>
                        <InputText id="email" v-model="email" type="email" :invalid="!!errors.email" placeholder="ejemplo@correo.com" fluid />
                        <small class="text-red-500" v-if="errors.email">{{ errors.email }}</small>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="password" class="font-semibold">Contraseña</label>
                        <Password id="password" v-model="password" :feedback="false" toggleMask fluid :invalid="!!errors.password" placeholder="********" />
                        <small class="text-red-500" v-if="errors.password">{{ errors.password }}</small>
                    </div>

                    <div class="flex justify-end">
                        <Button type="submit" label="¿Ha olvidado la contraseña?" link class="text-sm" />
                    </div>
                </div>

                <Button label="Entrar" icon="pi pi-sign-in" class="w-full" />
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