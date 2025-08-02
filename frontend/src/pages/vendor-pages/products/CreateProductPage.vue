<script setup lang="ts">
import { computed, onMounted, ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'

import ProductForm from './components/ProductForm.vue'

import useCreateorUpdateProduct from '../../../composables/useCreateUpdateProduct'
import { ProductType } from '../../../types'
import useToast from '../../../composables/useToast'
import ToastMessageNotification from '../../../components/ToastMessageNotification.vue'

const route = useRoute()
const router = useRouter()

const mode = ref<'edit' | 'create'>('create')
const productId = ref<number | undefined>(undefined)
const toast = useToast()

const { createError, success, createOrUpdateProduct, validationErrors, loading } = useCreateorUpdateProduct()

async function handleSubmit(product: ProductType, image: File) {
  createError.value = null
  success.value = false

  await createOrUpdateProduct(
    {
      productId: product.id,
      name: product.name,
      stock: product.stock_amount,
      price: product.price,
      categoryName: product.category?.name as string,
      category: String(product.category_id),
      image,
    },
    mode.value,
  )

  if (success.value) {
    toast.show('Product added successfully!', { variant: 'success', lifeTime: 2000 })
  }
}

const response = computed(() => {
  return {
    success: success.value,
    error: !!createError.value,
    formErrors: validationErrors.value,
  }
})

const previewSrc = ref('')

function setPreviewSrc(url: string) {
  previewSrc.value = url
}

const cancelCreate = () => {
  if (mode.value === 'edit') {
    router.push({
      name: 'catalog',
    })
  }
}

onMounted(async () => {
  if (route.name == 'edit-product') {
    mode.value = 'edit'
    productId.value = parseInt(route.params.id as string)
  }
})
</script>

<template>
  <ToastMessageNotification position="top" />
  <div id="main">
    <div class="main-viewport">
      <ProductForm
        :mode="mode"
        :product-id
        :loading
        :response
        :set-preview-image="setPreviewSrc"
        @submit="handleSubmit"
        @cancel="cancelCreate"
      />
      <div class="preview">
        <h4>Product Image</h4>
        <div v-show="previewSrc?.length > 0" class="preview-img">
          <img :src="previewSrc" alt="preview-product-image" />
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
div#main {
  position: relative;
  width: 100%;
  padding: 1rem 2rem;
}

.main-viewport {
  position: relative;
  display: flex;
  flex-wrap: wrap;
  gap: 2rem;
}

h4 {
  margin: 1rem 0.75rem;
}

/* preview section */
.preview {
  max-width: 400px;
  min-width: 400px;
}
div.preview-img {
  width: 400px;
  max-height: 410px;
  padding: 0.1rem;
  border: 1px solid rgb(221, 221, 221);
}

div.preview-img > img {
  width: 395px;
  max-height: 405px;
  object-fit: fill;
}
</style>
