import { createApp } from 'vue';
import { createPinia } from 'pinia';
import PrimeVue from 'primevue/config';
import Lara from '@primevue/themes/lara';
import Menubar from 'primevue/menubar';
import Button from 'primevue/button';
import Card from 'primevue/card';
import InputText from 'primevue/inputtext';
import Textarea from 'primevue/textarea';
import Avatar from 'primevue/avatar';
import 'primeicons/primeicons.css';
import 'primeflex/primeflex.css';
import App from './App.vue';
import router from './router';
import { definePreset } from '@primevue/themes';

const app = createApp(App);
const pinia = createPinia();

// Configura el tema Lara Light
const MyPreset = definePreset(Lara, {
  semantic: {
    primary: {
      50: '{cyan.50}',
      100: '{cyan.100}',
      200: '{cyan.200}',
      300: '{cyan.300}',
      400: '{cyan.400}',
      500: '{cyan.500}',
      600: '{cyan.600}',
      700: '{cyan.700}',
      800: '{cyan.800}',
      900: '{cyan.900}',
      950: '{cyan.950}'
    }
  }
});

// Configure PrimeVue with the Lara Light Blue theme (styled mode)
app.use(PrimeVue, {
  theme: {
    preset: MyPreset,
    options: {
      prefix: 'p',
      darkModeSelector: '.p-dark',
      cssLayer: false
    }
  }
});

// Install router (not heavily used for this single-page landing, but set up for potential navigation)
app.use(router);
app.use(pinia);

// Register PrimeVue components globally
app.component('Menubar', Menubar);
app.component('Button', Button);
app.component('Card', Card);
app.component('InputText', InputText);
app.component('Textarea', Textarea);
app.component('Avatar', Avatar);

// Mount the app
app.mount('#app');
