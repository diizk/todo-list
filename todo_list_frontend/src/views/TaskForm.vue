<template>
  <div class="flex h-screen">
    <Sidebar />

    <main class="flex-1 p-6 flex flex-col items-center justify-center">
      <h1 class="text-3xl font-bold text-text-light mb-6">
        {{ isEditing ? 'Editar Tarefa' : 'Criar Tarefa' }}
      </h1>
      
      <div class="w-full max-w-md p-8 space-y-6 bg-dark-card rounded-lg shadow-md">
        <form @submit.prevent="submitTask" class="space-y-4">
          <div>
            <label for="title" class="block text-sm font-medium text-text-light">Título</label>
            <input
              id="title"
              v-model="task.title"
              type="text"
              required
              class="block w-full px-3 py-2 mt-1 border-transparent rounded-md shadow-sm bg-dark-bg text-text-light focus:outline-none focus:ring-2 focus:ring-secondary-purple focus:border-transparent"
            />
          </div>
          <div>
            <label for="description" class="block text-sm font-medium text-text-light">Descrição</label>
            <textarea
              id="description"
              v-model="task.description"
              rows="4"
              class="block w-full px-3 py-2 mt-1 border-transparent rounded-md shadow-sm bg-dark-bg text-text-light focus:outline-none focus:ring-2 focus:ring-secondary-purple focus:border-transparent"
            ></textarea>
          </div>
          
          <div>
            <label for="status" class="block text-sm font-medium text-text-light">Status</label>
            <div class="relative mt-1">
              <select
                id="status"
                v-model="task.status"
                class="block w-full px-3 py-2 rounded-md shadow-sm text-center focus:outline-none appearance-none pr-8"
                :class="getStatusColor(task.status)"
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
          </div>
          
          <button
            type="submit"
            class="w-full px-4 py-2 text-text-light bg-primary-blue rounded-md hover:bg-secondary-purple transition-colors duration-200"
          >
            {{ isEditing ? 'Salvar Alterações' : 'Criar Tarefa' }}
          </button>
        </form>

        <button
          @click="router.back()"
          class="block w-full text-center text-secondary-purple hover:underline"
        >
          Voltar
        </button>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import axios from 'axios';
import Sidebar from '../components/Sidebar.vue';

const route = useRoute();
const router = useRouter();

const isEditing = ref(false);
const task = ref({
  title: '',
  description: '',
  status: 'pending'
});

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

onMounted(async () => {
  if (route.name === 'EditTask') {
    isEditing.value = true;
    try {
      const response = await axios.get(`${import.meta.env.VITE_API_BASE_URL}tasks/${route.params.id}`);
      task.value = response.data;
    } catch (error) {
      alert('Não foi possível carregar a tarefa.');
      router.back();
    }
  } else {
    isEditing.value = false;
    task.value = {
      title: '',
      description: '',
      status: 'pending'
    };
  }
});

const submitTask = async () => {
  try {
    if (isEditing.value) {
      await axios.patch(`${import.meta.env.VITE_API_BASE_URL}tasks/${route.params.id}`, task.value);
    } else {
      await axios.post(`${import.meta.env.VITE_API_BASE_URL}tasks`, task.value);
    }
    router.push('/');
  } catch (error) {
    alert('Falha ao salvar a tarefa.');
  }
};
</script>
