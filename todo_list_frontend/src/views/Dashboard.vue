<template>
  <div class="flex flex-col h-screen bg-gray-100">
    <header class="flex items-center justify-between px-6 py-4 bg-white border-b shadow-sm">
      <div class="text-xl font-semibold text-gray-800">
        Gerenciador de Tarefas
      </div>
      <div class="relative">
        <button
          @click="isMenuOpen = !isMenuOpen"
          class="flex items-center space-x-2 text-gray-600 focus:outline-none"
        >
          <span>Bem-vindo, {{ userName }}</span>
          <svg
            class="w-4 h-4 transition-transform duration-200"
            :class="{ 'rotate-180': isMenuOpen }"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
          </svg>
        </button>
        <div
          v-if="isMenuOpen"
          class="absolute right-0 w-48 mt-2 origin-top-right bg-white border rounded-md shadow-lg"
        >
          <a
            @click.prevent="logout"
            href="#"
            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
          >
            Sair
          </a>
        </div>
      </div>
    </header>

    <main class="flex-1 p-6 overflow-y-auto">
      <div class="max-w-4xl mx-auto">
        <h1 class="mb-6 text-3xl font-bold text-gray-800">Minhas Tarefas</h1>
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
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';

const router = useRouter();
const userName = ref('');
const tasks = ref([]);
const isMenuOpen = ref(false);

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

const fetchUserData = async () => {
  try {
    const response = await axios.get('http://127.0.0.1:8000/api/user');
    userName.value = response.data.name;
  } catch (error) {
    console.error('Erro ao buscar dados do usuário:', error);
    // Se o token for inválido, redireciona para o login
    router.push('/login');
  }
};

const fetchTasks = async () => {
  try {
    console.log('Fetching tasks...');
    const response = await axios.get('http://127.0.0.1:8000/api/tasks');
    tasks.value = response.data.data;
  } catch (error) {
    console.error('Erro ao buscar tarefas:', error);
  }
};

const updateStatus = async (task) => {
  try {
    await axios.patch(`http://127.0.0.1:8000/api/tasks/${task.id}`, { status: task.status });
    alert('Status atualizado!');
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
      alert('Tarefa deletada com sucesso!');
    } catch (error) {
      console.error('Erro ao deletar tarefa:', error);
      alert('Falha ao deletar a tarefa.');
    }
  }
};

const goToEditTask = (taskId) => {
  router.push(`/tasks/${taskId}/edit`);
};

const logout = () => {
  localStorage.removeItem('sanctum_token');
  axios.defaults.headers.common['Authorization'] = null;
  router.push('/login');
};

onMounted(() => {
  const storedUser = localStorage.getItem('user_data');
  if (storedUser) {
    const user = JSON.parse(storedUser);
    userName.value = user.name;
  }
  
  fetchTasks();
});
</script>

<style scoped>
/* Estilos para o select box */
select {
  @apply text-white;
}

select.bg-red-500 {
  background-color: #ef4444;
}

select.bg-yellow-500 {
  background-color: #f59e0b;
}

select.bg-green-500 {
  background-color: #10b981;
}
</style>