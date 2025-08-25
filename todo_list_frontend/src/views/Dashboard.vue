<template>
  <div class="flex h-screen">
    <Sidebar />

    <main class="flex-1 p-6 overflow-y-auto">
      <div class="max-w-4xl mx-auto">
        <div class="flex items-center justify-between mb-6">
          <h1 class="text-3xl font-bold text-text-light">Minhas Tarefas</h1>
          <button
            @click="goToCreateTask"
            class="px-4 py-2 text-text-light bg-primary-blue rounded-md hover:bg-secondary-purple transition-colors duration-200 focus:outline-none"
          >
            Criar Tarefa
          </button>
        </div>

        <div class="flex items-center justify-center space-x-4 py-4" v-if="tasks.length > 0">
          <button
            @click="goToPreviousPage"
            :disabled="currentPage === 1"
            :class="{ 'opacity-50 cursor-not-allowed': currentPage === 1 }"
            class="p-2 rounded-full text-text-light hover:bg-secondary-purple transition-colors duration-200"
          >
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
          </button>
          <span class="text-lg font-semibold text-text-light">Página {{ currentPage }} de {{ lastPage }}</span>
          <button
            @click="goToNextPage"
            :disabled="currentPage === lastPage"
            :class="{ 'opacity-50 cursor-not-allowed': currentPage === lastPage }"
            class="p-2 rounded-full text-text-light hover:bg-secondary-purple transition-colors duration-200"
          >
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
          </button>
        </div>

        <div class="space-y-4">
          <div
            v-for="task in tasks"
            :key="task.id"
            @click="goToEditTask(task.id)"
            class="flex items-center justify-between p-4 bg-dark-card rounded-lg shadow-md cursor-pointer hover:scale-105 transition-transform duration-200"
          >
            <span class="text-lg font-medium text-text-light">{{ task.title }}</span>

            <div class="flex items-center space-x-4">
              <div class="relative">
                <select
                  v-model="task.status"
                  @click.stop
                  @change="updateStatus(task)"
                  :class="getStatusColor(task.status)"
                  class="px-3 py-1 rounded-md shadow-sm text-center focus:outline-none appearance-none pr-8"
                >
                  <option value="pending" class="bg-[#F0A7A0] text-[#383D3B]">Pendente</option>
                  <option value="in_progress" class="bg-[#FFCBA4] text-[#383D3B]">Em Progresso</option>
                  <option value="done" class="bg-[#A8D0A5] text-[#383D3B]">Concluído</option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                  <svg class="w-4 h-4 text-text-light" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                  </svg>
                </div>
              </div>

              <button @click.stop="deleteTask(task.id)" class="p-1 rounded-md text-text-light hover:text-accent-pink transition-colors duration-200 focus:outline-none">
                <svg
                  class="w-6 h-6"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                  ></path>
                </svg>
              </button>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue'; 
import { useRouter, useRoute } from 'vue-router';
import axios from 'axios';
import Sidebar from '../components/Sidebar.vue';

const router = useRouter();
const route = useRoute();
const tasks = ref([]);

const currentPage = ref(1);
const lastPage = ref(1);
const links = ref([]);

const getStatusColor = (status) => {
  switch (status) {
    case 'in_progress':
      return 'bg-[#FFCBA4] text-[#383D3B]';
    case 'done':
      return 'bg-[#A8D0A5] text-[#383D3B]';
    case 'pending':
      return 'bg-[#F0A7A0] text-[#383D3B]';
    default:
      return 'bg-gray-400 text-[#383D3B]';
  }
};

const fetchTasks = async (page = 1) => {
  try {
    const response = await axios.get(`${import.meta.env.VITE_API_BASE_URL}tasks?page=${page}`);
    tasks.value = response.data.data;
    currentPage.value = response.data.current_page;
    lastPage.value = response.data.last_page;
    links.value = response.data.links;
  } catch (error) {
    console.error('Erro ao buscar tarefas:', error);
  }
};

const updateStatus = async (task) => {
  try {
    await axios.patch(`${import.meta.env.VITE_API_BASE_URL}tasks/${task.id}`, { status: task.status });
  } catch (error) {
    alert('Falha ao atualizar o status.');
  }
};

const deleteTask = async (taskId) => {
  if (confirm('Tem certeza que deseja deletar esta tarefa?')) {
    try {
      await axios.delete(`${import.meta.env.VITE_API_BASE_URL}tasks/${taskId}`);
      tasks.value = tasks.value.filter(task => task.id !== taskId);
      fetchTasks(currentPage.value);
    } catch (error) {
      alert('Falha ao deletar a tarefa.');
    }
  }
};

const goToNextPage = () => {
  if (currentPage.value < lastPage.value) {
    fetchTasks(currentPage.value + 1);
  }
};

const goToPreviousPage = () => {
  if (currentPage.value > 1) {
    fetchTasks(currentPage.value - 1);
  }
};

const goToEditTask = (taskId) => {
  router.push({ name: 'EditTask', params: { id: taskId } });
};

const goToCreateTask = () => {
  router.push({ name: 'CreateTask' });
};

watch(() => route.path, (newPath) => {
  if (newPath === '/') {
    fetchTasks();
  }
});

onMounted(() => {
  fetchTasks();
});
</script>

<style scoped>
</style>
