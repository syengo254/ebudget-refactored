<script setup lang="ts">
import { onMounted, ref } from 'vue'
import { ProductType } from '../../../types'
import { useAuthStore } from '../../../stores/authStore'
import Pagination from '../../../components/Pagination.vue'
import useProducts from '../../../composables/useProducts'
import SimpleProductCard from '../../../components/SimpleProductCard.vue'
import { isAxiosError } from 'axios'
import BaseButton from '../../../components/buttons/BaseButton.vue'

const products = ref<ProductType[]>([])
const paginationData = ref([])
const authStore = useAuthStore()
const { fetch } = useProducts()

onMounted(async () => {
  if (products.value.length < 1) {
    await fetchProducts()
  }
})

async function fetchProducts(page: number = 1) {
  const response = await fetch(page, { store: authStore.user?.store?.name })

  if (!isAxiosError(response)) {
    products.value = response.data
    paginationData.value = response.meta
  }
}

async function nextPage(page: number) {
  await fetchProducts(page)
}
</script>
<template>
  <section>
    <div class="my-product-viewport">
      <div class="my-products-container">
        <Pagination class="mb-1" :pagination-handler="nextPage" :meta="paginationData" />
        <div class="my-products">
          <SimpleProductCard
            v-for="product in products"
            :key="product.name"
            style="border: 1px solid gray"
            :product="product"
          >
            <div style="display: flex; justify-content: space-between">
              <BaseButton type="button" variant="primary">Edit</BaseButton>
              <BaseButton type="button" variant="error">Delete</BaseButton>
            </div>
          </SimpleProductCard>
        </div>
      </div>
    </div>
  </section>
</template>

<style scoped>
section {
  padding: 1rem 2rem;
}

div.my-products {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 1rem;
}
</style>
