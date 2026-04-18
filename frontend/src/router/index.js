import { createRouter, createWebHistory } from 'vue-router';
import { useAuthStore } from '@/stores/auth';

const routes = [
  // GRUPO PÚBLICO
  {
    path: '/',
    component: () => import('@/layouts/AuthLayout.vue'),
    children: [
      {
        path: '', 
        name: 'login',
        meta: { guestOnly: true },
        component: () => import('@/views/auth/LoginView.vue')
      },
      {
        path: '/register', 
        name: 'register',
        meta: { guestOnly: true },
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
        meta: { requiresAuth: true },
        component: () => import('@/views/dashboard/DashboardView.vue')
      }
    ]
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

router.beforeEach(async (to, from, next) => {
    const authStore = useAuthStore();

    if (authStore.authUser === null) {
        await authStore.getUser();
    }

    if (to.meta.requiresAuth && !authStore.isAuthenticated) {
        return next({ name: 'login' });
    }

    if (to.meta.guestOnly && authStore.isAuthenticated) {
        return next({ name: 'dashboard' });
    }
    next();
});

export default router;