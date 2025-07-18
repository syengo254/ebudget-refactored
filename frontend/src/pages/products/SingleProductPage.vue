<script setup lang="ts">
import { onMounted, ref } from 'vue'
import { useRoute } from 'vue-router'

import { useProductStore } from '../../stores/productStore'
import { ProductType } from '../../types'

const productStore = useProductStore()
const route = useRoute()
const product = ref<ProductType | null>(null)

onMounted(async () => {
  const productId = route.params.id as string
  if (productId) {
    product.value = await productStore.getOrFetch(parseInt(productId))
  }
})
</script>

<template>
  <div>Yeah viewing product {{ product }}</div>
</template>

<style scoped></style>
