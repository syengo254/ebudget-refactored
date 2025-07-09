<script setup lang="ts">
import ProductCard from '../../../components/ProductCard.vue'
import Pagination from '../../../components/Pagination.vue'
import LoadingComponent from '../../../components/LoadingComponent.vue'
import ErrorComponent from '../../../components/ErrorComponent.vue'
import { useProductStore } from '../../../stores/productStore'
import { onMounted } from 'vue'

const productStore = useProductStore()

onMounted(async () => {
  await productStore.fetchProducts()
})

async function handler(page: number = 1) {
  await productStore.fetchProducts(page)

  window.scrollTo(0, 0)
}
</script>

<template>
  <LoadingComponent v-if="productStore.loading && !productStore.error" />
  <ErrorComponent
    v-if="productStore.error"
    :error="productStore.error"
    :action="
      async () => {
        await productStore.refetch()
      }
    "
  />

  <div v-if="!productStore.loading && !productStore.error" class="product-panel">
    <div style="display: flex; flex-direction: column; margin-bottom: 1rem">
      <h4 style="margin-bottom: 0.5rem">Our products</h4>
      <Pagination :pagination-handler="handler" :meta="productStore.pagination" />
    </div>

    <div id="products-root">
      <ProductCard v-for="product in productStore.products" :key="product.id + product.name" :product="product" />
    </div>
    <Pagination style="margin-bottom: 2rem" :pagination-handler="handler" :meta="productStore.pagination" />
  </div>
</template>

<style scoped>
div.product-panel {
  max-width: 1400px;
  width: 100%;
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
