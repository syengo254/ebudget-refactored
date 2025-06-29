import { createRouter, createWebHistory } from 'vue-router'

import HomePage from '../pages/home/HomePage.vue';
import RegisterPage from '../pages/register/RegisterPage.vue';
import LoginPage from '../pages/login/LoginPage.vue';
import AboutPage from '../pages/about/AboutPage.vue';

const routes = [
  {
    path: '/',
    component: HomePage,
  },
  {
    path: '/signup',
    component: RegisterPage,
  },
  {
    path: '/signin',
    component: LoginPage,
  },
  {
    path: '/about',
    component: AboutPage,
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
