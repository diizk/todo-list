<template>
  <div class="flex items-center justify-center h-screen bg-gray-100">
    <div class="w-full max-w-md p-8 space-y-6 bg-white rounded-lg shadow-md">
      <h2 class="text-2xl font-bold text-center">
        {{ isRegistering ? 'Criar Conta' : 'Entrar' }}
      </h2>

      <form v-if="!isRegistering" @submit.prevent="login" class="space-y-4">
        <div>
          <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
          <input
            id="email"
            v-model="loginForm.email"
            type="email"
            required
            class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm"
          />
        </div>
        <div>
          <label for="password" class="block text-sm font-medium text-gray-700">Senha</label>
          <input
            id="password"
            v-model="loginForm.password"
            type="password"
            required
            class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm"
          />
        </div>
        <button
          type="submit"
          class="w-full px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700"
        >
          Entrar
        </button>
      </form>

      <form v-else @submit.prevent="register" class="space-y-4">
        <div>
          <label for="name" class="block text-sm font-medium text-gray-700">Nome</label>
          <input
            id="name"
            v-model="registerForm.name"
            type="text"
            required
            class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm"
          />
        </div>
        <div>
          <label for="email-register" class="block text-sm font-medium text-gray-700">Email</label>
          <input
            id="email-register"
            v-model="registerForm.email"
            type="email"
            required
            class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm"
          />
        </div>
        <div>
          <label for="password-register" class="block text-sm font-medium text-gray-700">Senha</label>
          <input
            id="password-register"
            v-model="registerForm.password"
            type="password"
            required
            class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm"
          />
        </div>
        <div>
          <label for="password-confirm" class="block text-sm font-medium text-gray-700">Confirmação de Senha</label>
          <input
            id="password-confirm"
            v-model="registerForm.password_confirmation"
            type="password"
            required
            class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm"
          />
        </div>
        <button
          type="submit"
          class="w-full px-4 py-2 text-white bg-green-600 rounded-md hover:bg-green-700"
        >
          Criar Conta
        </button>
      </form>

      <button @click="toggleForm" class="block w-full text-center text-blue-500">
        {{ isRegistering ? 'Já tem uma conta? Entre!' : 'Não tem uma conta? Crie uma!' }}
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';

const isRegistering = ref(false);

const loginForm = ref({
  email: '',
  password: ''
});

const registerForm = ref({
  name: '',
  email: '',
  password: '',
  password_confirmation: ''
});

const toggleForm = () => {
  isRegistering.value = !isRegistering.value;
};

const login = async () => {
  try {
    const response = await axios.post('http://127.0.0.1:8000/api/login', loginForm.value);
    console.log('Login successful:', response.data);
    alert('Login realizado com sucesso!');
    // TODO: Redirecionar para a página de tarefas ou salvar o token
  } catch (error) {
    console.error('Login failed:', error.response.data);
    alert('Erro ao fazer login. Verifique suas credenciais.');
  }
};

const register = async () => {
  if (registerForm.value.password !== registerForm.value.password_confirmation) {
    alert('As senhas não coincidem!');
    return;
  }

  try {
    const response = await axios.post('http://127.0.0.1:8000/api/register', registerForm.value);
    console.log('Registration successful:', response.data);
    alert('Registro realizado com sucesso!');
    isRegistering.value = false; // Alterna para a tela de login após o registro
  } catch (error) {
    console.error('Registration failed:', error.response.data);
    alert('Erro ao registrar. Tente novamente.');
  }
};
</script>

<style scoped>
/* Adicione estilos específicos do componente aqui se necessário */
</style>