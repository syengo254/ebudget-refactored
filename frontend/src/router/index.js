import { createRouter, createWebHistory } from 'vue-router'

import HomePage from '../pages/home/HomePage.vue'
import AboutPage from '../pages/about/AboutPage.vue'
import UserProfilePage from '../pages/profile/UserProfilePage.vue'

const routes = [
  {
    path: '/',
    component: HomePage,
    name: 'home',
    meta: {
      title: 'Home | E-budget.com | Best Online Shoping Experience',
    },
  },
  {
    path: '/profile',
    component: UserProfilePage,
    name: 'profile',
    meta: {
      title: 'User Profile | Edit your information | E-budget.com | Best Online Shoping Experience',
      requiresAuth: true,
      forceCheckServerAuth: true, // ignore local storage data
    },
  },
  {
    path: '/register',
    component: () => import('../pages/register/RegisterPage.vue'),
    name: 'register',
    meta: {
      title: 'Register | E-budget.com | Best Online Shoping Experience',
    },
  },
  {
    path: '/login',
    component: () => import('../pages/login/LoginPage.vue'),
    name: 'login',
    meta: {
      title: 'Login | E-budget.com | Best Online Shoping Experience',
    },
  },
  {
    path: '/about',
    component: AboutPage,
    name: 'about',
    meta: {
      title: 'About | E-budget.com | Best Online Shoping Experience',
    },
  },
  {
    path: '/products/store/:id',
    name: 'products',
  },
  {
    path: '/products/:id',
    name: 'products',
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

export default router
