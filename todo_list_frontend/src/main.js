import './assets/main.css'

import { createApp } from 'vue'
import { createPinia } from 'pinia'

import App from './App.vue'
import router from './router'
import axios from 'axios'
import './assets/main.css';

axios.defaults.baseURL = 'http://localhost:8000/api/'

axios.interceptors.request.use(
  (config) => {
    const token = localStorage.getItem('sanctum_token');
    if (token) {
      config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
  },
  (error) => {
    return Promise.reject(error);
  }
);

const app = createApp(App)

app.use(createPinia())
app.use(router)

app.mount('#app')
