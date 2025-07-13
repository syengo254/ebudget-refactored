import { createRouter, createWebHistory } from 'vue-router'

import HomePage from '../pages/home/HomePage.vue'
import AboutPage from '../pages/about/AboutPage.vue'
import UserProfilePage from '../pages/profile/UserProfilePage.vue'
import DashboardPage from '../pages/dashboard/DashboardPage.vue'
import AllProductsPage from '../pages/products/AllProductsPage.vue'
import ShoppingCartPage from '../pages/shopping-cart/ShoppingCartPage.vue'

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
    path: '/dashboard',
    component: DashboardPage,
    name: 'dashboard',
    meta: {
      title: 'Dashboard | E-budget.com | Best Online Shoping Experience',
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
      requiresGuest: true,
    },
  },
  {
    path: '/login',
    component: () => import('../pages/login/LoginPage.vue'),
    name: 'login',
    meta: {
      title: 'Login | E-budget.com | Best Online Shoping Experience',
      requiresGuest: true,
    },
  },
  {
    path: '/reset-password',
    component: () => import('../pages/reset-password/ResetPasswordPage.vue'),
    name: 'reset-password',
    meta: {
      title: 'Reset your password | E-budget.com | Best Online Shoping Experience',
      requiresGuest: true,
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
    path: '/products/store',
    name: 'products',
  },
  {
    path: '/products',
    name: 'products',
    component: AllProductsPage,
  },
  {
    path: '/checkout',
    name: 'checkout',
    component: () => import('../pages/checkout/Index.vue'),
    meta: {
      title: 'Checkout | E-budget.com | Best Online Shoping Experience',
      requiresAuth: true,
      forceCheckServerAuth: false, // ignore local storage data
    },
  },
  {
    path: '/shopping-cart',
    name: 'shopping-cart',
    component: ShoppingCartPage,
    meta: {
      title: 'Shopping Cart | E-budget.com | Best Online Shoping Experience',
    },
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

export default router
