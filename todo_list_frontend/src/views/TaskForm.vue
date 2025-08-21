<template>
  <div class="flex h-screen bg-gray-100">
    <Sidebar />

    <main class="flex-1 p-6 flex items-center justify-center">
      <div class="w-full max-w-md p-8 space-y-6 bg-white rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-center">
          {{ isEditing ? 'Editar Tarefa' : 'Criar Tarefa' }}
        </h2>

        <form @submit.prevent="submitTask" class="space-y-4">
          <div>
            <label for="title" class="block text-sm font-medium text-gray-700">Título</label>
            <input
              id="title"
              v-model="task.title"
              type="text"
              required
              class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm"
            />
          </div>
          <div>
            <label for="description" class="block text-sm font-medium text-gray-700">Descrição</label>
            <textarea
              id="description"
              v-model="task.description"
              rows="4"
              class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm"
            ></textarea>
          </div>
          
          <div>
            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
            <select
              id="status"
              v-model="task.status"
              class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm"
            >
              <option value="pending">Pendente</option>
              <option value="in_progress">Em Progresso</option>
              <option value="done">Concluído</option>
            </select>
          </div>
          
          <button
            type="submit"
            class="w-full px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700"
          >
            {{ isEditing ? 'Salvar Alterações' : 'Criar Tarefa' }}
          </button>
        </form>

        <button
          @click="router.back()"
          class="block w-full text-center text-gray-500 hover:underline"
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

onMounted(async () => {
  if (route.name === 'EditTask') {
    isEditing.value = true;
    try {
      const response = await axios.get(`http://127.0.0.1:8000/api/tasks/${route.params.id}`);
      task.value = response.data;
    } catch (error) {
      console.error('Erro ao buscar tarefa:', error);
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
      await axios.patch(`http://127.0.0.1:8000/api/tasks/${route.params.id}`, task.value);
    } else {
      await axios.post('http://127.0.0.1:8000/api/tasks', task.value);
    }
    router.push('/');
  } catch (error) {
    console.error('Erro ao salvar tarefa:', error.response.data);
    alert('Falha ao salvar a tarefa.');
  }
};
</script>