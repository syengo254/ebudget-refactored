<script setup lang="ts">
import MenuBar from '@/assets/menu-bar.png'
import { useProductStore } from '../../stores/productStore'
import { RouterLink } from 'vue-router'
import { useAuthStore } from '../../stores/authStore'

const productStore = useProductStore()
const authStore = useAuthStore()

function checkFilters() {
  // if clicked filters shoudl be cleared
  if (productStore.hasFilters) {
    productStore.clearFilters()
  }
  return true
}
</script>

<template>
  <section v-if="!authStore.hasStore" id="categories-bar">
    <RouterLink to="/">
      <img class="menu-icon" :src="MenuBar" alt="menu-bar" />
      <span>All</span>
    </RouterLink>
    <nav>
      <RouterLink :to="{ name: 'home' }">Home</RouterLink>
      <RouterLink :to="{ name: 'home' }">Today's Deals</RouterLink>
      <RouterLink :to="{ name: 'products' }" @click="checkFilters">All Products</RouterLink>
      <RouterLink v-if="authStore.loggedIn" :to="{ name: 'profile' }" style="margin-left: auto; margin-right: 1rem"
        >My Account</RouterLink
      >
      <RouterLink v-else to="/about">About</RouterLink>
    </nav>
  </section>
  <section v-else id="categories-bar">
    <RouterLink :to="{ name: 'dashboard' }">
      <img class="menu-icon" :src="authStore.user?.store?.logo" alt="menu-bar" />
    </RouterLink>
    <nav>
      <RouterLink :to="{ name: 'dashboard' }">Dashboard</RouterLink>
      <RouterLink :to="{ name: 'add-product' }">Add Product</RouterLink>
      <RouterLink :to="{ name: 'catalog' }">My Products</RouterLink>
      <RouterLink :to="{ name: 'sales' }">Sales</RouterLink>
      <RouterLink :to="{ name: 'profile' }" style="margin-left: auto; margin-right: 1rem">My Account</RouterLink>
    </nav>
  </section>
</template>

<style scoped>
nav {
  display: inline-flex;
  flex-wrap: wrap;
  column-gap: 2rem;
  width: 100%;
}

nav > a,
ul.small-nav > li > a {
  color: white;
  text-decoration: none;
  font-size: 1rem;
}

nav > a {
  display: inline-block;
  text-align: center;
}
#categories-bar {
  height: 50px;
  background-color: rgb(34, 51, 144);
  border-bottom: 1px solid white;
  display: flex;
  align-items: center;
  padding-left: 1rem;
  color: white;
  gap: 0.5rem;
}

#categories-bar a {
  text-decoration: none;
  padding: 0.5rem 0.5rem;
  display: block;
  box-sizing: content-box;
  border: 1px solid transparent;
}

#categories-bar a:hover {
  text-decoration: none;
  border: 1px solid white;
}

#categories-bar > a:first-of-type {
  display: flex;
  column-gap: 0.5rem;
  align-items: center;
  color: white;
  text-decoration: none;
  outline: none;
}

#categories-bar > a > img.menu-icon {
  width: 24px;
  height: 24px;
  cursor: pointer;
}

#categories-bar > a > span {
  margin-right: 1rem;
  font-weight: bold;
}
</style>
