<script setup lang="ts">
import useProducts from '../../composables/useProducts'
import ProductsPanel from './components/ProductsPanel.vue'

const { products, refetch, loading, error, pagination } = useProducts()
</script>

<template>
  <h4>Our products</h4>
  <div v-if="loading">Loading products, please wait...</div>
  <div v-if="error">
    An error occured whilst fetching products: {{ error.message }}

    <button type="button" @click="() => refetch()">Refetch</button>
  </div>
  <ProductsPanel v-if="!loading && !error" :pagination :products :refetch />
</template>
