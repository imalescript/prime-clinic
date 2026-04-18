import { createRouter, createWebHistory } from 'vue-router';

const routes = [
  // GRUPO PÚBLICO
  {
    path: '/',
    component: () => import('@/layouts/AuthLayout.vue'),
    children: [
      {
        path: '', 
        name: 'login',
        component: () => import('@/views/auth/LoginView.vue')
      },
      {
        path: 'register', 
        name: 'register',
        component: () => import('@/views/auth/RegisterView.vue')
      }
    ]
  },

  // GRUPO PRIVADO 
  {
    path: '/dashboard',
    component: () => import('@/layouts/AppLayout.vue'),
    children: [
      {
        path: '',
        name: 'dashboard',
        component: () => import('@/views/dashboard/DashboardView.vue')
      }
      // Más adelante agregaremos /patients, /surgeries, etc. aquí
    ]
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

export default router;