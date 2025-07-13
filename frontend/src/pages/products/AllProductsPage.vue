<script setup lang="ts">
import CategoriesPanel from './components/CategoriesPanel.vue'
import ProductsPanel from './components/ProductsPanel.vue'
import PromotionsPanel from './components/PromotionsPanel.vue'
</script>

<template>
  <Suspense>
    <section class="main">
      <CategoriesPanel />
      <ProductsPanel />
      <PromotionsPanel />
    </section>
    <template #fallback> Loading... </template>
  </Suspense>
</template>

<style scoped>
section.main {
  position: relative;
  display: flex;
  flex-direction: row;
  flex-wrap: wrap;
  margin: 0;
  padding: 0;
  padding-inline: 1rem;
}
</style>
