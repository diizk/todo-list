import { defineStore } from 'pinia';
import axios from 'axios';

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null,
    token: null,
  }),
  actions: {
    setToken(token) {
      this.token = token;
      localStorage.setItem('auth_token', token);
      axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
    },
    clearToken() {
      this.token = null;
      this.user = null;
      localStorage.removeItem('auth_token');
      delete axios.defaults.headers.common['Authorization'];
    },
    async fetchUser() {
      if (!this.token) {
        return;
      }
      try {
        const response = await axios.get('http://localhost:8080/api/user');
        this.user = response.data;
      } catch (error) {
        this.clearToken();
      }
    },
  },
});