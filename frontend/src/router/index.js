import { createRouter, createWebHistory } from 'vue-router';
import { useAuthStore } from '@/stores/auth';

const routes = [
  // GRUPO PÚBLICO
  {
    path: '/',
    meta: { guestOnly: true },
    component: () => import('@/layouts/AuthLayout.vue'),
    children: [
      {
        path: '', 
        name: 'login',
        component: () => import('@/views/auth/LoginView.vue')
      },
      {
        path: '/register', 
        name: 'register',
        component: () => import('@/views/auth/RegisterView.vue')
      }
    ]
  },

  // GRUPO PRIVADO 
  {
    path: '/dashboard',
    meta: { requiresAuth: true },
    component: () => import('@/layouts/AppLayout.vue'),
    children: [
      {
        path: '',
        name: 'dashboard',
        component: () => import('@/views/dashboard/DashboardView.vue')
      },
      {
        path: '/patient/:id',
        name: 'patients.show',
        component: () => import('@/views/dashboard/PatientDetailView.vue')
      },
      {
        path: 'patient/:id/update',
        name: 'patients.update',
        component: () => import('@/views/dashboard/PatientFormView.vue'),
        props: true 
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