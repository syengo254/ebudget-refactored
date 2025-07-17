import { createRouter, createWebHistory } from 'vue-router'

import HomePage from '../pages/home/HomePage.vue'
import AboutPage from '../pages/about/AboutPage.vue'
import UserProfilePage from '../pages/profile/UserProfilePage.vue'
import AllProductsPage from '../pages/products/AllProductsPage.vue'
import ShoppingCartPage from '../pages/shopping-cart/ShoppingCartPage.vue'

import vendorRoutes from './vendor'

// make guards arrays i.e. meta.guards: ["auth", "guest", "verified", etc]

const routes = [
  {
    path: '/',
    component: HomePage,
    name: 'home',
    meta: {
      title: 'Home | E-budget.com | Best Online Shoping Experience',
      guards: ['user'],
    },
  },
  {
    path: '/profile',
    component: UserProfilePage,
    name: 'profile',
    meta: {
      title: 'User Profile | Edit your information | E-budget.com | Best Online Shoping Experience',
      guards: ['auth'],
    },
  },
  //========= Vendor Routes =============
  vendorRoutes,
  //========= End Vendor Routes =============
  {
    path: '/register',
    component: () => import('../pages/register/RegisterPage.vue'),
    name: 'register',
    meta: {
      title: 'Register | E-budget.com | Best Online Shoping Experience',
      guards: ['guest'],
    },
  },
  {
    path: '/login',
    component: () => import('../pages/login/LoginPage.vue'),
    name: 'login',
    meta: {
      title: 'Login | E-budget.com | Best Online Shoping Experience',
      guards: ['guest'],
    },
  },
  {
    path: '/reset-password',
    component: () => import('../pages/reset-password/ResetPasswordPage.vue'),
    name: 'reset-password',
    meta: {
      title: 'Reset your password | E-budget.com | Best Online Shoping Experience',
      guards: ['guest'],
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
      guards: ['verified', 'user'],
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
  {
    path: '/verify-account',
    name: 'verify-account',
    component: () => import('../components/UnverifiedAccountNotice.vue'),
    meta: {
      title: 'Account Verification | E-budget.com | Best Online Shoping Experience',
      guards: ['auth', 'unverified'],
    },
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

export default router
