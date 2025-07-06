<script setup lang="ts">
import ProductCard from '../../../components/ProductCard.vue'
import Pagination from '../../../components/Pagination.vue'
import { PropType } from 'vue'
import { ProductType } from '../../../types'

const props = defineProps({
  pagination: {
    type: Object,
    required: true,
  },
  refetch: {
    type: Function,
    required: true,
  },
  products: {
    type: Array as PropType<ProductType[]>,
    required: true,
  },
})

async function handler(page: number = 1) {
  await props.refetch(page)
}
</script>

<template>
  <div class="product-panel">
    <Pagination :pagination-handler="handler" :meta="pagination.meta" />

    <div id="products-root">
      <ProductCard v-for="product in products" :key="product.id + product.name" :product="product" />
    </div>
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
