<script setup lang="ts">
import CategoriesPanel from '../home/components/CategoriesPanel.vue'
import ProductsPanel from '../home/components/ProductsPanel.vue'
import PromotionsPanel from '../home/components/PromotionsPanel.vue'
</script>

<template>
  <section class="main">
    <CategoriesPanel />
    <ProductsPanel />
    <PromotionsPanel />
  </section>
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
