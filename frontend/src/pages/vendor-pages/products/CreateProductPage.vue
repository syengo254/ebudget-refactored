<script setup lang="ts">
import { onMounted, ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useAuthStore } from '../../../stores/authStore'
import { useProductStore } from '../../../stores/productStore'

import BaseButton from '../../../components/buttons/BaseButton.vue'
import Error from '../../../components/forms/Error.vue'
import FormInput from '../../../components/forms/FormInput.vue'
import FormSelect from '../../../components/forms/FormSelect.vue'
import FormTextArea from '../../../components/forms/FormTextArea.vue'
import SuccessAlert from '../../../components/SuccessAlert.vue'
import ErrorAlert from '../../../components/ErrorAlert.vue'
import useCreateorUpdateProduct from '../../../composables/useCreateUpdateProduct'
import { ProductType } from '../../../types'
import { useVendorStore } from '../../../stores/vendorStore'

const authStore = useAuthStore()
const productStore = useProductStore()
const vendorStore = useVendorStore()
const router = useRouter()
const route = useRoute()

/**
 * This SFC is used for both editing or creating a product
 * The @var mode is used to distinguish whether to edit or create
 *
 */
const mode = ref<'edit' | 'create'>('create')

const name = ref('')
const productId = ref(0)
const categoryName = ref('')
const price = ref('')
const stock = ref('')
const category = ref('')
const image = ref<File | null>(null)
const previewSrc = ref('')

const { loading, createError, success, createOrUpdateProduct, validationErrors } = useCreateorUpdateProduct()

function handleFileChange(event: string | undefined) {
  if (event !== 'image') return

  const target = document.getElementById(event) as HTMLInputElement
  if (target && target.files && target.files.length > 0) {
    image.value = target.files[0]
    previewSrc.value = URL.createObjectURL(image.value)
  } else {
    image.value = null
  }
}

const cancelCreate = () => {
  if (mode.value === 'create') {
    resetForm()
  }
  router.push({
    name: 'catalog',
  })
}

function resetForm() {
  const form = document.querySelector('div.product-form > form') as HTMLFormElement
  form.reset()
  image.value = null
}

async function handleSubmit() {
  validationErrors.value = null
  createError.value = null
  success.value = false

  await createOrUpdateProduct({
    name: name.value,
    categoryName: categoryName.value,
    price: parseFloat(price.value),
    stock: parseInt(stock.value),
    category: category.value,
    image: image.value as File,
    ...(mode.value === 'edit' ? { productId: productId.value } : {}),
  })

  if (success.value && mode.value === 'create') {
    resetForm()
  }

  if (success.value && authStore.user?.store?.name) {
    // refresh
    await vendorStore.fetchVendorProducts(authStore.user?.store?.name, 1)
  }
}

onMounted(async () => {
  await productStore.fetchCategories()

  if (route.name == 'edit-product') {
    mode.value = 'edit'
    const product: ProductType = await vendorStore.getOrFetch(parseInt(route.params.id as string))

    name.value = product.name
    price.value = String(product.price)
    stock.value = String(product.stock_amount)
    category.value = String(product.category_id ?? product.category?.id)
    productId.value = product.id
    previewSrc.value = product.image
  }
})
</script>

<template>
  <div id="main">
    <div class="main-viewport">
      <div class="product-form">
        <h4>Add a product ({{ authStore.user?.store?.name }})</h4>
        <form @submit.prevent="handleSubmit">
          <fieldset>
            <legend><h5>Product Details</h5></legend>
            <div class="form-group">
              <FormTextArea
                v-model="name"
                name="name"
                label="Product Name & Description"
                placeholder="Samsung 24' TV - 2025 Model - Specifications: ..."
                rows="3"
                required
              >
                <Error :form-errors="validationErrors?.name" />
              </FormTextArea>
              <div class="flex flex-row flex-wrap" style="column-gap: 2rem">
                <div class="form-group">
                  <FormInput
                    v-model="price"
                    name="price"
                    label="Price of the product (KES)"
                    type="number"
                    placeholder="e.g. 60000"
                    required
                  >
                    <Error :form-errors="validationErrors?.price" />
                  </FormInput>
                </div>
                <div class="form-group">
                  <FormInput
                    v-model="stock"
                    name="stock"
                    label="Available Stock"
                    type="number"
                    placeholder="e.g. 10"
                    required
                  >
                    <Error :form-errors="validationErrors?.stock" />
                  </FormInput>
                </div>
                <div class="form-group">
                  <FormInput
                    name="image"
                    label="An image of the product (.png, .jpg, .jpeg & .webp)"
                    type="file"
                    :required="mode === 'create'"
                    @file-changed="handleFileChange"
                  >
                    <Error :form-errors="validationErrors?.image" />
                  </FormInput>
                </div>
              </div>
              <FormSelect
                v-model="category"
                name="category"
                label="Select Product Category"
                :required="categoryName.length < 2"
              >
                <option value="" selected>Select a category</option>
                <template #options>
                  <option
                    v-for="_category in productStore.getCategories"
                    :key="_category.name"
                    :value="String(_category.id)"
                  >
                    {{ _category.name }}
                  </option>
                </template>
                <template #error-slot>
                  <Error :form-errors="validationErrors?.category" />
                </template>
              </FormSelect>
              <div class="form-group">
                <FormInput
                  v-model="categoryName"
                  name="category-name"
                  label="or Add a category (Optional if selected above)"
                  placeholder="e.g. Beverages, Tables, etc."
                >
                  <Error :form-errors="validationErrors?.categoryname" />
                </FormInput>
              </div>
            </div>
            <div class="submit-btns flex flex-row gap-1">
              <BaseButton variant="outlined" style="border-radius: 3.5px" @click="cancelCreate">Cancel</BaseButton>
              <BaseButton v-if="mode === 'edit'" variant="primary" style="margin-left: auto" :disabled="loading">{{
                loading ? 'Save...' : 'Save'
              }}</BaseButton>
              <BaseButton v-else style="margin-left: auto" variant="primary" :disabled="loading">{{
                loading ? 'Adding...' : 'Add'
              }}</BaseButton>
            </div>
          </fieldset>
          <div class="response flex flex-column">
            <SuccessAlert
              :show="success"
              :msg="mode === 'edit' ? 'Changes saved.' : 'Product added successfully'"
              :show-tick="true"
            />
            <ErrorAlert
              :show="!!createError"
              :msg="
                mode === 'edit'
                  ? 'Unable to save your changes'
                  : 'Could not create your product, please reload the page and try again.'
              "
            />
          </div>
        </form>
      </div>
      <div class="preview">
        <h4>Product Image</h4>
        <div v-show="previewSrc?.length ?? false" class="preview-img">
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

.product-form {
  position: relative;
  min-width: 450px;
}

h4 {
  margin: 1rem 0.75rem;
}

h5 {
  margin: 0.2rem;
}

.submit-btns {
  width: 100%;
  align-items: center;
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
