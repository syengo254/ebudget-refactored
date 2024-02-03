import { createRouter, createWebHistory } from 'vue-router'

import Home from '../pages/home/Home.vue';
import SignupPage from '../pages/signup/SignupPage.vue';
import SigninPage from '../pages/signin/SigninPage.vue';
import AboutPage from '../pages/about/AboutPage.vue';

const routes = [
  {
    path: '/',
    component: Home,
  },
  {
    path: '/signup',
    component: SignupPage,
  },
  {
    path: '/signin',
    component: SigninPage,
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
