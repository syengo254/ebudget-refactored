<script setup lang="ts">
import { onMounted, ref } from 'vue'
import { useRouter } from 'vue-router'

import { useAuthStore } from '../../../stores/authStore'
import { useVendorStore } from '../../../stores/vendorStore'

import Pagination from '../../../components/Pagination.vue'
import SimpleProductCard from '../../../components/SimpleProductCard.vue'
import BaseButton from '../../../components/buttons/BaseButton.vue'
import LoadingComponent from '../../../components/LoadingComponent.vue'

const router = useRouter()
const authStore = useAuthStore()
const vendorStore = useVendorStore()
const loading = ref(false)

onMounted(async () => {
  if (vendorStore.vendorProducts.length < 1) {
    await loadProducts()
  }
})

async function loadProducts(page: number = 1) {
  if (authStore.user?.store?.name) {
    loading.value = true
    await vendorStore.fetchVendorProducts(authStore.user?.store?.name, page)
    loading.value = false
  }
}

function openEditPage(productId: number) {
  router.push(`/vendor/product/${productId}/edit`)
}
</script>
<template>
  <section id="main-view">
    <div class="my-product-viewport">
      <h4>Products Owned By {{ authStore.user?.store?.name }}</h4>
      <LoadingComponent v-if="loading" />
      <div v-else class="my-products-container">
        <section class="products-head mb-1">
          <Pagination :pagination-handler="loadProducts" :meta="vendorStore.catalog.paginationData" />
          <BaseButton type="button" variant="secondary" @click="router.push({ name: 'add-product' })"
            >+ Add a product</BaseButton
          >
        </section>
        <div class="my-products">
          <SimpleProductCard
            v-for="product in vendorStore.vendorProducts"
            :key="product.name"
            style="border: 1px solid gray"
            :product="product"
            :dont-navigate="true"
          >
            <div style="display: flex; justify-content: space-between">
              <BaseButton
                type="button"
                variant="primary"
                @click="
                  (e: Event) => {
                    e.stopPropagation()
                    openEditPage(product.id)
                  }
                "
                >Edit</BaseButton
              >
              <BaseButton type="button" variant="error">Delete</BaseButton>
            </div>
          </SimpleProductCard>
        </div>
      </div>
    </div>
  </section>
</template>

<style scoped>
section#main-view {
  padding: 1rem 2rem;
}

h4 {
  text-align: center;
  font-size: large;
  padding: 0;
  margin: 0;
}

section.products-head {
  display: flex;
  align-items: center;
  flex-wrap: wrap;
  justify-content: space-between;
}

div.my-products {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 1.5rem;
  padding-bottom: 2rem;
}
</style>
