<script setup lang="ts">
import ProductCard from '../../../components/ProductCard.vue'
import Pagination from '../../../components/Pagination.vue'
import useProducts from '../../../composables/useProducts'
import LoadingComponent from '../../../components/LoadingComponent.vue'
import ErrorComponent from '../../../components/ErrorComponent.vue'

const { products, refetch, loading, error, pagination } = useProducts()

async function handler(page: number = 1) {
  await refetch(page)

  window.scrollTo(0, 0)
}
</script>

<template>
  <LoadingComponent v-if="loading && !error" />
  <ErrorComponent v-if="error" :error="error" :action="refetch" />

  <div v-if="!loading && !error" class="product-panel">
    <div style="display: flex; flex-direction: row; align-items: center; justify-content: space-between">
      <h4>Our products</h4>
      <Pagination :pagination-handler="handler" :meta="pagination.meta" />
    </div>

    <div id="products-root">
      <ProductCard v-for="product in products" :key="product.id + product.name" :product="product" />
    </div>
    <Pagination :pagination-handler="handler" :meta="pagination.meta" />
  </div>
</template>

<style scoped>
div.product-panel {
  max-width: 1400px;
  --max-items: 4;
  max-width: calc(var(--max-items) * 238px + var(--max-items) * 1rem);
}

#products-root {
  position: relative;
  display: flex;
  flex-flow: row wrap;
  gap: 1rem;
  margin-bottom: 5rem;
  width: fit-content;
  align-items: stretch;
  /* margin-inline: auto; */
}
@media screen and (max-width: 400px) {
  #products-root {
    max-width: 210px;
    margin-inline: none;
    display: flex;
    flex-direction: column;
    gap: 0px;
    row-gap: 1rem;
  }
}
</style>
