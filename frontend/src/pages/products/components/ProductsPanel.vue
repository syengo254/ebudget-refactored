<script setup lang="ts">
import ProductCard from '../../../components/ProductCard.vue'
import Pagination from '../../../components/Pagination.vue'
import LoadingComponent from '../../../components/LoadingComponent.vue'
import ErrorComponent from '../../../components/ErrorComponent.vue'
import { useProductStore } from '../../../stores/productStore'
import { computed } from 'vue'
import ErrorBoundary from '../../../components/ErrorBoundary.vue'
import { ProductsFiltersType, ProductType } from '../../../types'
import { useCartStore } from '../../../stores/cartStore'

const productStore = useProductStore()
const shoppingCart = useCartStore()

const hasFilters = computed(() => Object.keys(productStore.filters).length > 0)

await productStore.fetchProducts()

async function handlerPagination(page: number = 1) {
  await productStore.fetchProducts(false, page)

  window.scrollTo(0, 0)
}

function handleAddToCart(product: ProductType) {
  shoppingCart.addItem(product)
}

function handleRemoveFromCart(product: ProductType) {
  shoppingCart.removeItem(product.id, true)
}

function removeFilter(filterName: keyof ProductsFiltersType) {
  productStore.removeFilter(filterName)
}
</script>

<template>
  <ErrorBoundary>
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
        <ul v-if="hasFilters" class="filters-list text-white">
          <li v-for="filter in productStore.getFilters" :key="filter.name">
            <span>{{ (filter.name == 'q' ? '' : filter.name + ': ') + filter.value }}</span>
            <button class="text-white" @click="removeFilter(filter.name as keyof ProductsFiltersType)">x</button>
          </li>
        </ul>
        <h4 style="margin-bottom: 0.5rem">{{ hasFilters ? 'Filtered products' : 'Our products' }}</h4>
        <Pagination :pagination-handler="handlerPagination" :meta="productStore.pagination" />
      </div>

      <div id="products-root">
        <ProductCard
          v-for="product in productStore.products"
          :key="product.id + product.name"
          :product="product"
          @add-to-cart="handleAddToCart(product)"
          @remove="handleRemoveFromCart(product)"
        />
      </div>
      <Pagination style="margin-bottom: 2rem" :pagination-handler="handlerPagination" :meta="productStore.pagination" />
    </div>
  </ErrorBoundary>
</template>

<style scoped>
div.product-panel {
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
@media screen and (max-width: 420px) {
  #products-root {
    width: 100vw;
    margin-inline: none;
    display: flex;
    flex-grow: 1;
    flex-direction: column;
    gap: 0px;
    row-gap: 1rem;
  }
  div.product-panel {
    width: 98vw;
    max-width: 100vw;
    margin-inline: 0.5rem;
  }
}

ul.filters-list {
  padding: 0;
  margin: 0;
  margin-top: 0.5rem;
  list-style: none;
  display: flex;
  align-items: center;
  column-gap: 0.2rem;
}

ul.filters-list > li {
  background-color: rgb(30, 45, 125);
  padding: 0.2rem 0.6rem;
  border-radius: 1rem;
  font-size: 0.75rem !important;
}

ul.filters-list > li > span {
  text-transform: capitalize;
}

ul.filters-list > li > button {
  margin-left: 0.3rem;
  background-color: rgb(30, 45, 125);
  font-size: 0.9rem;
  font-weight: 600;
  cursor: pointer;
  outline: none;
  border: none;
}
</style>
