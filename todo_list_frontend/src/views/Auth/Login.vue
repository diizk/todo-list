<template>
  <div class="flex items-center justify-center h-screen">
    <div class="w-full max-w-md p-8 space-y-6 bg-[#252827] rounded-lg shadow-md">
      <h2 class="text-2xl font-bold text-center text-[#E5E5E5]">
        {{ isRegistering ? 'Criar Conta' : 'Entrar' }}
      </h2>

      <form v-if="!isRegistering" @submit.prevent="login" class="space-y-4">
        <div>
          <label for="email" class="block text-sm font-medium text-[#E5E5E5]">Email</label>
          <input
            id="email"
            v-model="loginForm.email"
            type="email"
            required
            class="block w-full px-3 py-2 mt-1 border-transparent rounded-md shadow-sm bg-[#383D3B] text-[#E5E5E5] focus:outline-none focus:ring-2 focus:ring-[#947BD3] focus:border-transparent"
          />
        </div>
        <div>
          <label for="password" class="block text-sm font-medium text-[#E5E5E5]">Senha</label>
          <input
            id="password"
            v-model="loginForm.password"
            type="password"
            required
            class="block w-full px-3 py-2 mt-1 border-transparent rounded-md shadow-sm bg-[#383D3B] text-[#E5E5E5] focus:outline-none focus:ring-2 focus:ring-[#947BD3] focus:border-transparent"
          />
        </div>
        <button
          type="submit"
          class="w-full px-4 py-2 text-[#E5E5E5] bg-[#5E4AE3] rounded-md hover:bg-[#947BD3] transition-colors duration-200"
        >
          Entrar
        </button>
      </form>

      <form v-else @submit.prevent="register" class="space-y-4">
        <div>
          <label for="name" class="block text-sm font-medium text-[#E5E5E5]">Nome</label>
          <input
            id="name"
            v-model="registerForm.name"
            type="text"
            required
            class="block w-full px-3 py-2 mt-1 border-transparent rounded-md shadow-sm bg-[#383D3B] text-[#E5E5E5] focus:outline-none focus:ring-2 focus:ring-[#947BD3] focus:border-transparent"
          />
        </div>
        <div>
          <label for="email-register" class="block text-sm font-medium text-[#E5E5E5]">Email</label>
          <input
            id="email-register"
            v-model="registerForm.email"
            type="email"
            required
            class="block w-full px-3 py-2 mt-1 border-transparent rounded-md shadow-sm bg-[#383D3B] text-[#E5E5E5] focus:outline-none focus:ring-2 focus:ring-[#947BD3] focus:border-transparent"
          />
        </div>
        <div>
          <label for="password-register" class="block text-sm font-medium text-[#E5E5E5]">Senha</label>
          <input
            id="password-register"
            v-model="registerForm.password"
            type="password"
            required
            class="block w-full px-3 py-2 mt-1 border-transparent rounded-md shadow-sm bg-[#383D3B] text-[#E5E5E5] focus:outline-none focus:ring-2 focus:ring-[#947BD3] focus:border-transparent"
          />
        </div>
        <div>
          <label for="password-confirm" class="block text-sm font-medium text-[#E5E5E5]">Confirmação de Senha</label>
          <input
            id="password-confirm"
            v-model="registerForm.password_confirmation"
            type="password"
            required
            class="block w-full px-3 py-2 mt-1 border-transparent rounded-md shadow-sm bg-[#383D3B] text-[#E5E5E5] focus:outline-none focus:ring-2 focus:ring-[#947BD3] focus:border-transparent"
          />
        </div>
        <button
          type="submit"
          class="w-full px-4 py-2 text-[#E5E5E5] bg-[#5E4AE3] rounded-md hover:bg-[#947BD3] transition-colors duration-200"
        >
          Criar Conta
        </button>
      </form>

      <button @click="toggleForm" class="block w-full text-center text-[#947BD3] hover:underline">
        {{ isRegistering ? 'Já tem uma conta? Entre!' : 'Não tem uma conta? Crie uma!' }}
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';

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

const router = useRouter();

const login = async () => {
  try {
    const response = await axios.post('http://127.0.0.1:8000/api/login', loginForm.value);
    
    const token = response.data.access_token;
    const user = response.data.data;
    
    localStorage.setItem('sanctum_token', token);
    localStorage.setItem('user_data', JSON.stringify(user));
    
    axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;

    console.log('Login realizado com sucesso!');
    router.push('/');
  } catch (error) {
    console.error('Falha no login:', error.response.data);
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
    console.log('Registro realizado com sucesso:', response.data);
    isRegistering.value = false;
    router.push('/');
  } catch (error) {
    if (error.response) {
      console.error('Falha no registro:', error.response.data);
      alert('Erro ao registrar. Tente novamente.');
    } else {
      console.error('Erro de rede:', error.message);
      alert('Erro de rede. Verifique a sua conexão ou se o servidor está online.');
    }
  }
};
</script>

<style scoped>
</style>