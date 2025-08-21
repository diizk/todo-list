<template>
  <aside class="w-64 bg-white p-4 space-y-4 shadow-lg">
    <div class="flex items-center space-x-2">
      <svg
        class="h-8 w-8 text-blue-600"
        fill="none"
        stroke="currentColor"
        viewBox="0 0 24 24"
        xmlns="http://www.w3.org/2000/svg"
      >
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          stroke-width="2"
          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M16 16h.01"
        ></path>
      </svg>
      <span class="text-xl font-bold text-gray-800">Todo List</span>
    </div>

    <nav class="space-y-2">
      <router-link
        to="/"
        class="flex items-center space-x-2 p-2 rounded-lg"
        :class="{
          'bg-blue-100 text-blue-700 font-medium': route.path === '/',
          'text-gray-600 hover:bg-gray-100': route.path !== '/'
        }"
      >
        <svg
          class="h-5 w-5"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-9v10a1 1 0 01-1 1h-3m-6 0v-9a1 1 0 011-1h2a1 1 0 011 1v3m-5 3v1h8v-1m-4 5h1"
          ></path>
        </svg>
        <span>Dashboard</span>
      </router-link>
    </nav>

    <div class="pt-8">
      <div class="text-sm font-semibold text-gray-500 mb-2">Usuário:</div>
      <div class="flex items-center space-x-2">
        <div class="flex-shrink-0">
          <svg
            class="h-8 w-8 text-gray-400"
            fill="currentColor"
            viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"
            ></path>
          </svg>
        </div>
        <div>
          <div class="text-lg font-bold text-gray-900">{{ userName }}</div>
          <div class="text-sm text-gray-500">Online</div>
        </div>
      </div>
    </div>
    <div class="mt-auto">
      <button
        @click="logout"
        class="w-full flex items-center justify-center px-4 py-2 text-white bg-red-600 rounded-md hover:bg-red-700 focus:outline-none"
      >
        <svg
          class="w-5 h-5 mr-2"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1m0-5V8m0 9v-2m0 2H7a2 2 0 01-2-2V8a2 2 0 012-2h6"
          ></path>
        </svg>
        Sair
      </button>
    </div>
  </aside>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import axios from 'axios';

const router = useRouter();
const route = useRoute();
const userName = ref('');

const fetchAuthenticatedUser = async () => {
  try {
    const response = await axios.get('http://127.0.0.1:8000/api/user');
    userName.value = response.data.name;
    localStorage.setItem('user_data', JSON.stringify(response.data));
  } catch (error) {
    console.error('Erro ao buscar dados do usuário autenticado:', error);
    router.push('/login');
  }
};

const logout = () => {
  localStorage.removeItem('sanctum_token');
  localStorage.removeItem('user_data');
  axios.defaults.headers.common['Authorization'] = null;
  router.push('/login');
};

onMounted(() => {
  fetchAuthenticatedUser();
});
</script>