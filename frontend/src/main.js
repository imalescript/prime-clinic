import { createApp } from 'vue';
import './style.css'
import { createPinia } from 'pinia';
import router from './router';
import App from './App.vue';

import PrimeVue from 'primevue/config';
import Aura from '@primevue/themes/aura';
import 'primeicons/primeicons.css'

const app = createApp(App);
const pinia = createPinia();

app.use(pinia);
app.use(router);
app.use(PrimeVue, {
    theme: {
        preset: Aura,
        options: {
            darkModeSelector: '.p-dark',
            cssLayer: {
                name: 'primevue',
                order: 'theme, base, primevue'
            }
        }
    }
});

app.mount('#app');