<script setup lang="ts">
import { RouterLink } from 'vue-router'
</script>
<template>
  <div class="vendor-main">
    <router-view />
    <div class="quick-links mt-1">
      <nav>
        <RouterLink :to="{ name: 'profile' }">Edit Store Information</RouterLink>
        <RouterLink :to="{ name: 'catalog' }">My Products</RouterLink>
        <RouterLink :to="{ name: 'sales' }">Orders From My Store</RouterLink>
        <RouterLink to="#" aria-disabled="true">Reports</RouterLink>
      </nav>
    </div>
  </div>
</template>

<style scoped>
.vendor-main {
  padding: 0;
  margin: 0;
}
/* quick links */
.quick-links nav {
  display: flex;
  gap: 2rem;
  justify-content: center;
  margin-block: 2rem;
}
</style>
