import { createRouter, createWebHistory } from 'vue-router';
import LoginView from '../views/auth/Login.vue';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'login',
      component: LoginView
    },
    {
      path: '/register',
      name: 'register',
      component: () => import('../views/auth/Register.vue')
    },
    {
      path: '/dashboard',
      name: 'dashboard',
      component: () => import('../views/pages/Dashboard.vue'),
      beforeEnter: (to, from, next) => {
        if (!localStorage.getItem('user_info')) return next('/');
        JSON.parse(localStorage.getItem('user_info')).user_type == 1 ? next() : next('/');
      }
    },
    {
      path: '/home',
      name: 'home',
      component: () => import('../views/pages/Home.vue'),
      beforeEnter: (to, from, next) => {
        if (!localStorage.getItem('user_info')) return next('/');
        JSON.parse(localStorage.getItem('user_info')).user_type == 0 ? next() : next('/');
      }
    },
    {
      path: '/orders',
      name: 'orders',
      component: () => import('../views/pages/Orders.vue'),
      beforeEnter: (to, from, next) => {
        if (!localStorage.getItem('user_info')) return next('/');
        JSON.parse(localStorage.getItem('user_info')).user_type == 0 ? next() : next('/');
      }
    },
  ]
})

export default router;
