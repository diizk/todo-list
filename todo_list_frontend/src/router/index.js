import { createRouter, createWebHistory } from 'vue-router'
import Login from '../views/Auth/Login.vue'
import Dashboard from '../views/Dashboard.vue'
import TaskForm from '../views/TaskForm.vue'

const routes = [
  {
    path: '/login',
    name: 'Login',
    component: Login,
  },
  {
    path: '/',
    name: 'Dashboard',
    component: Dashboard,
    meta: { requiresAuth: true },
  },
  {
    path: '/task/:id',
    name: 'EditTask',
    component: TaskForm,
    meta: { requiresAuth: true },
  },
  {
    path: '/task/create',
    name: 'CreateTask',
    component: TaskForm,
    meta: { requiresAuth: true },
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

router.beforeEach((to, from, next) => {
  const token = localStorage.getItem('sanctum_token');
  if (to.matched.some(record => record.meta.requiresAuth) && !token) {
    next('/login');
  } else {
    next();
  }
});

export default router
