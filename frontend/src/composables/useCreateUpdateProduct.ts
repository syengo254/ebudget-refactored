import { AxiosError, isAxiosError } from 'axios'
import useProducts from './useProducts'
import { ref } from 'vue'

type CreateProductType = {
  name: string
  stock: number
  price: number
  category: string
  categoryName: string
  image: File
  productId?: number
}

export type ProductFormValidationErrorType = {
  name?: string[]
  price?: string[]
  category?: string[]
  stock?: string[]
  image?: string[]
  categoryname?: string[]
} | null

export default function useCreateUpdateProduct() {
  const { addProduct, updateProduct } = useProducts()

  const createError = ref<null | Error | AxiosError>(null)
  const success = ref<boolean>(false)
  const loading = ref<boolean>(false)
  const validationErrors = ref<ProductFormValidationErrorType | null>(null)

  async function createOrUpdateProduct(
    { productId, name, stock, price, categoryName, category, image }: CreateProductType,
    mode: 'create' | 'edit',
  ) {
    // submit
    validationErrors.value = null
    const formData = new FormData()
    formData.append('name', name)
    formData.append('price', String(price))
    formData.append('stock', String(stock))
    if (categoryName.length > 0) {
      formData.append('categoryname', categoryName)
    } else {
      formData.append('category', category)
    }
    if (mode === 'edit') {
      formData.append('id', String(productId))
    }
    if (image) {
      formData.append('image', image)
      if (productId) formData.append('imageHasChanged', '1')
    }

    let response = null

    loading.value = true
    response = mode === 'create' ? await addProduct(formData) : await updateProduct(productId as number, formData)
    loading.value = false

    // handle response
    if (isAxiosError(response)) {
      if (response.response?.data.errors) {
        validationErrors.value = response.response?.data.errors
      } else {
        createError.value = response
      }
    } else if (response instanceof Error) {
      createError.value = response
    } else {
      success.value = response.success
    }
  }

  return {
    createOrUpdateProduct,
    createError,
    loading,
    success,
    validationErrors,
  }
}
