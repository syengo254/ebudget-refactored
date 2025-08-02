<script setup lang="ts">
import { computed, onMounted, PropType, reactive, ref, watch } from 'vue'
import FormTextArea from '../../../../components/forms/FormTextArea.vue'
import FormInput from '../../../../components/forms/FormInput.vue'
import Error from '../../../../components/forms/Error.vue'
import FormSelect from '../../../../components/forms/FormSelect.vue'
import BaseButton from '../../../../components/buttons/BaseButton.vue'
import SuccessAlert from '../../../../components/SuccessAlert.vue'
import ErrorAlert from '../../../../components/ErrorAlert.vue'

import { ProductFormValidationErrorType } from '../../../../composables/useCreateUpdateProduct'
import { useProductStore } from '../../../../stores/productStore'
import { useVendorStore } from '../../../../stores/vendorStore'
import { CategoryType, ProductType } from '../../../../types'
import { useAuthStore } from '../../../../stores/authStore'

const emit = defineEmits(['submit', 'cancel'])

const { productId, mode, response, setPreviewImage } = defineProps({
  mode: {
    type: String as PropType<'edit' | 'create'>,
    required: true,
  },
  response: {
    type: Object as PropType<{ success: boolean; error: boolean; formErrors?: ProductFormValidationErrorType }>,
    required: false,
    default: () => ({ success: false, error: false }),
  },
  loading: {
    type: Boolean,
    required: true,
  },
  productId: {
    type: Number,
    required: false,
    default: undefined,
  },
  setPreviewImage: {
    type: Function,
    required: true,
  },
})

type PType = Omit<ProductType, 'store' | 'store_id'> & { category: CategoryType }

const authStore = useAuthStore()
const productStore = useProductStore()
const vendorStore = useVendorStore()
const image = ref<File | null>(null)
const validationErrors = ref<ProductFormValidationErrorType | null>(null)
const product = reactive<PType>({
  id: 0,
  name: '',
  price: 10,
  stock_amount: 0,
  image: '',
  category_id: 0,
  category: {
    id: 0,
    name: '',
  },
})

const header = computed(() =>
  mode == 'create' ? `Add a product (${authStore.user?.store?.name})` : 'Editing product ' + product.name,
)

function handleSubmit() {
  if (validate()) {
    validationErrors.value = null
    emit('submit', product, image.value)
  }
}

function handleFileChange(event: string | undefined) {
  if (event !== 'image') return

  const target = document.getElementById(event) as HTMLInputElement
  if (target && target.files && target.files.length > 0) {
    image.value = target.files[0]
    setPreviewImage(URL.createObjectURL(image.value))
  } else {
    image.value = null
  }
}

function validate(): boolean {
  // console.table(product)

  if (product.name.length < 8) {
    validationErrors.value = {
      name: ['Name should be a minimum of 8 characters'],
    }
    return false
  }
  if (product.price < 10) {
    validationErrors.value = {
      price: ['Price minimum should be KES 10'],
    }
    return false
  }
  if (product.stock_amount < 3) {
    validationErrors.value = {
      stock: ['Stock minimum should be 3'],
    }
    return false
  }
  if (product.category_id === 0 && product.category?.name === '') {
    validationErrors.value = {
      category: ['You must select or add a category'],
    }
    return false
  }
  if (!image.value && !product.id) {
    validationErrors.value = {
      image: ['You must set the product image'],
    }
    return false
  }

  if (image.value && image.value.size > 1000 * 1000 * 2) {
    validationErrors.value = {
      image: ['Image size cannot be more than 2MB'],
    }
    return false
  }

  return true
}

function resetForm() {
  const form = document.querySelector('div.product-form > form') as HTMLFormElement
  if (mode === 'create') {
    form.reset()
    image.value = null
  }
}

function handleCancel() {
  resetForm()
  emit('cancel')
}

const allFormErrors = computed(() => validationErrors.value ?? response.formErrors)

onMounted(async () => {
  await productStore.fetchCategories()

  if (productId) {
    const fetchedP = await vendorStore.getOrFetch(productId)
    product.name = fetchedP.name
    product.price = fetchedP.price
    product.stock_amount = fetchedP.stock_amount
    // product.category = fetchedP.category as CategoryType
    product.category_id = fetchedP.category?.id ?? 0
    product.id = fetchedP.id

    setPreviewImage(fetchedP.image)
  }
})

watch(
  () => response.success,
  () => {
    if (response.success) {
      vendorStore.fetchVendorProducts(authStore.user?.store?.name as string, 1)
      resetForm()
    }
  },
  { deep: true },
)
</script>

<template>
  <div class="product-form">
    <h4>{{ header }}</h4>
    <form @submit.prevent="handleSubmit">
      <fieldset>
        <legend><h5>Product Details</h5></legend>
        <div class="form-group">
          <FormTextArea
            v-model="product.name"
            name="name"
            label="Product Name & Description"
            placeholder="Samsung 24' TV - 2025 Model - Specifications: ..."
            rows="3"
            required
          >
            <Error :form-errors="allFormErrors?.name" />
          </FormTextArea>
          <div class="flex flex-row flex-wrap" style="column-gap: 2rem">
            <div class="form-group">
              <FormInput
                v-model="product.price"
                name="price"
                label="Price of the product (KES)"
                type="number"
                placeholder="e.g. 60000"
                required
              >
                <Error :form-errors="allFormErrors?.price" />
              </FormInput>
            </div>
            <div class="form-group">
              <FormInput
                v-model="product.stock_amount"
                name="stock"
                label="Available Stock"
                type="number"
                placeholder="e.g. 10"
                required
              >
                <Error :form-errors="allFormErrors?.stock" />
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
                <Error :form-errors="allFormErrors?.image" />
              </FormInput>
            </div>
          </div>
          <FormSelect
            v-model="product.category_id"
            name="category"
            label="Select Product Category"
            :required="(product.category?.name?.length ?? 0) < 2"
          >
            <template #options>
              <option value="0" selected>Select a category</option>
              <option
                v-for="_category in productStore.getCategories"
                :key="_category.name"
                :value="String(_category.id)"
              >
                {{ _category.name }}
              </option>
            </template>
            <template #error-slot>
              <Error :form-errors="allFormErrors?.category" />
            </template>
          </FormSelect>
          <div class="form-group">
            <FormInput
              v-model="product.category.name"
              name="category-name"
              label="or Add a category (Optional if selected above)"
              placeholder="e.g. Beverages, Tables, etc."
            >
              <Error :form-errors="allFormErrors?.categoryname" />
            </FormInput>
          </div>
        </div>
        <div class="submit-btns flex flex-row gap-1">
          <BaseButton variant="outlined" style="border-radius: 3.5px" @click="handleCancel">Cancel</BaseButton>
          <BaseButton
            v-if="mode === 'edit'"
            type="submit"
            variant="primary"
            style="margin-left: auto"
            :disabled="loading"
            >{{ loading ? 'Save...' : 'Save' }}</BaseButton
          >
          <BaseButton v-else type="submit" style="margin-left: auto" variant="primary" :disabled="loading">{{
            loading ? 'Adding...' : 'Add'
          }}</BaseButton>
        </div>
      </fieldset>
      <div class="response flex flex-column">
        <SuccessAlert
          :show="response.success"
          :msg="mode === 'edit' ? 'Changes saved.' : 'Product added successfully'"
          :show-tick="true"
        />
        <ErrorAlert
          :show="response.error"
          :msg="
            mode === 'edit'
              ? 'Unable to save your changes'
              : 'Could not create your product, please reload the page and try again.'
          "
        />
      </div>
    </form>
  </div>
</template>

<style scoped>
.product-form {
  position: relative;
  min-width: 450px;
}

.submit-btns {
  width: 100%;
  align-items: center;
}

h4 {
  margin: 1rem 0.75rem;
}

h5 {
  margin: 0.2rem;
}
</style>
