import { createRouter, createWebHistory } from 'vue-router'

import HomePage from '../pages/home/HomePage.vue'
import RegisterPage from '../pages/register/RegisterPage.vue'
import LoginPage from '../pages/login/LoginPage.vue'
import AboutPage from '../pages/about/AboutPage.vue'

const routes = [
  {
    path: '/',
    component: HomePage,
    name: 'home',
  },
  {
    path: '/register',
    component: RegisterPage,
    name: 'register',
  },
  {
    path: '/login',
    component: LoginPage,
    name: 'login',
  },
  {
    path: '/about',
    component: AboutPage,
    name: 'about',
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

export default router
