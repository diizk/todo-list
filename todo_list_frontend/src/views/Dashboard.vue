<template>
  <div class="flex h-screen bg-gray-100">
    <Sidebar />

    <main class="flex-1 p-6 overflow-y-auto">
      <div class="max-w-4xl mx-auto">
        <div class="flex items-center justify-between mb-6">
          <h1 class="text-3xl font-bold text-gray-800">Minhas Tarefas</h1>
          <button
            @click="goToCreateTask"
            class="px-4 py-2 text-white bg-green-500 rounded-md hover:bg-green-600 focus:outline-none"
          >
            Criar Tarefa
          </button>
        </div>

        <div class="flex items-center justify-center space-x-4 py-4" v-if="tasks.length > 0">
          <button
            @click="goToPreviousPage"
            :disabled="currentPage === 1"
            :class="{ 'opacity-50 cursor-not-allowed': currentPage === 1 }"
            class="p-2 rounded-full text-gray-600 hover:bg-gray-200"
          >
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
          </button>
          <span class="text-lg font-semibold text-gray-700">Página {{ currentPage }} de {{ lastPage }}</span>
          <button
            @click="goToNextPage"
            :disabled="currentPage === lastPage"
            :class="{ 'opacity-50 cursor-not-allowed': currentPage === lastPage }"
            class="p-2 rounded-full text-gray-600 hover:bg-gray-200"
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
            class="flex items-center justify-between p-4 bg-white rounded-lg shadow-md cursor-pointer"
          >
            <span class="text-lg font-medium text-gray-900">{{ task.title }}</span>

            <div class="flex items-center space-x-4">
              <select
                v-model="task.status"
                @click.stop
                @change="updateStatus(task)"
                :class="getStatusColor(task.status)"
                class="px-3 py-1 text-white rounded-md shadow-sm appearance-none focus:outline-none"
              >
                <option value="pending" class="bg-red-500">Pendente</option>
                <option value="in_progress" class="bg-yellow-500">Em Progresso</option>
                <option value="done" class="bg-green-500">Concluído</option>
              </select>

              <button @click.stop="deleteTask(task.id)" class="text-gray-400 hover:text-red-600 focus:outline-none">
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
      return 'bg-yellow-500';
    case 'done':
      return 'bg-green-500';
    case 'pending':
      return 'bg-red-500';
    default:
      return 'bg-gray-400';
  }
};

const fetchTasks = async (page = 1) => {
  try {
    const response = await axios.get(`http://127.0.0.1:8000/api/tasks?page=${page}`);
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
    await axios.patch(`http://127.0.0.1:8000/api/tasks/${task.id}`, { status: task.status });
  } catch (error) {
    console.error('Erro ao atualizar status:', error);
    alert('Falha ao atualizar o status.');
  }
};

const deleteTask = async (taskId) => {
  if (confirm('Tem certeza que deseja deletar esta tarefa?')) {
    try {
      await axios.delete(`http://127.0.0.1:8000/api/tasks/${taskId}`);
      tasks.value = tasks.value.filter(task => task.id !== taskId);
      fetchTasks(currentPage.value);
    } catch (error) {
      console.error('Erro ao deletar tarefa:', error);
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
/* Adicione estilos específicos do componente aqui se necessário */
</style>