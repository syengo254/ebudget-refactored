<script setup lang="ts">
import { computed, onMounted, ref } from 'vue'
import { useRoute } from 'vue-router'

import { useProductStore } from '../../stores/productStore'
import { BreadcrumpItemType, ProductType } from '../../types'
import ProductExtraImages from './components/ProductExtraImages.vue'
import SingleProductDetails from './components/SingleProductDetails.vue'
import MiniCart from './components/MiniCart.vue'
import LoadingComponent from '../../components/LoadingComponent.vue'
import ErrorComponent from '../../components/ErrorComponent.vue'
import ProductGroupView from '../../components/products/ProductGroupView.vue'
import BreadCrumpComponent from '../../components/BreadCrumpComponent.vue'

const productStore = useProductStore()

const route = useRoute()
const product = ref<ProductType | null>(null)
const loading = ref(false)
const error = ref<boolean | Error>(false)

async function loadProduct() {
  const productId = route.params.id as string
  if (productId) {
    try {
      loading.value = true
      error.value = false
      product.value = await productStore.getOrFetch(parseInt(productId))
    } catch (err) {
      // eslint-disable-next-line no-console
      console.error(err)
      error.value = err as Error
    } finally {
      loading.value = false
    }
  }
}

const breadCrumps = computed(() => [
  {
    item: product.value?.category?.name,
    link: `/products?filterCategory=${product.value?.category?.name}`,
  },
  {
    item: product.value?.name,
  },
])

onMounted(async () => {
  await loadProduct()
})
</script>

<template>
  <LoadingComponent v-if="loading" />

  <ErrorComponent v-if="!!error" :error="error as Error" :action="loadProduct" />

  <BreadCrumpComponent :items="breadCrumps as BreadcrumpItemType[]" style="margin-top: 1rem" />

  <div v-if="product" class="product-viewport">
    <ProductExtraImages :image="product?.image ?? ''" />
    <div class="product-main-image">
      <img :src="product?.image" alt="product-image-1" />
    </div>

    <SingleProductDetails :product="product" />

    <MiniCart :product="product" />
  </div>

  <!-- Related products -->
  <div v-if="product">
    <ProductGroupView
      :key="product?.category?.name"
      heading="Related products"
      :grouping="{ key: 'category', name: product?.category?.name as string }"
    />
  </div>
</template>

<style scoped>
.product-viewport {
  display: flex;
  flex-wrap: wrap;
  margin: 1rem 2rem;
  gap: 2rem;
}

.product-main-image {
  align-self: center;
}

.product-main-image > img {
  width: 300px;
  height: 300px;
  object-fit: fill;
}
</style>
