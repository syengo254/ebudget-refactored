import { createRouter, createWebHistory } from 'vue-router'

import HomePage from '../pages/home/HomePage.vue'
import AboutPage from '../pages/about/AboutPage.vue'

const routes = [
  {
    path: '/',
    component: HomePage,
    name: 'home',
  },
  {
    path: '/register',
    component: () => import('../pages/register/RegisterPage.vue'),
    name: 'register',
  },
  {
    path: '/login',
    component: () => import('../pages/login/LoginPage.vue'),
    name: 'login',
  },
  {
    path: '/about',
    component: AboutPage,
    name: 'about',
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
