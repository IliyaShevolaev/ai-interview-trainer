import './assets/main.css'
import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import axios from './axios-config';
import 'bootstrap/dist/css/bootstrap.min.css';

const app = createApp(App);

app.use(router);

app.config.globalProperties.$axios = axios;

app.mount('#app');
