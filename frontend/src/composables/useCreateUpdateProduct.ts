import { AxiosError, isAxiosError } from 'axios'
import useProducts from './useProducts'
import { ref } from 'vue'

type CreateProductType = {
  name: string
  stock: string
  price: string
  category: string
  categoryName: string
  image: File
}

export default function useCreateUpdateProduct() {
  const { addProduct } = useProducts()
  const validationErrors = ref<{
    name?: string[]
    price?: string[]
    category?: string[]
    stock?: string[]
    image?: string[]
    categoryname?: string[]
  } | null>(null)

  const createError = ref<null | Error | AxiosError>(null)
  const success = ref<boolean>(false)
  const loading = ref<boolean>(false)

  function validate({ name, stock, price, categoryName, category, image }: CreateProductType): boolean {
    // validate
    if (name.length < 8) {
      validationErrors.value = {
        name: ['Name should be a minimum of 8 characters'],
      }
      return false
    }
    if (price.length < 10) {
      validationErrors.value = {
        price: ['Price minimum should be KES 10'],
      }
      return false
    }
    if (stock.length < 10) {
      validationErrors.value = {
        stock: ['Stock minimum should be 1'],
      }
      return false
    }
    if (categoryName === '' && category === '') {
      validationErrors.value = {
        category: ['You must select or add a category'],
      }
      return false
    }
    if (!image) {
      validationErrors.value = {
        image: ['You must set the product image'],
      }
      return false
    }

    if (image.size > 1000 * 1000 * 5) {
      validationErrors.value = {
        image: ['Image size cannot be more than 5MB'],
      }
      return false
    }

    return true
  }

  async function createProduct({ name, stock, price, categoryName, category, image }: CreateProductType) {
    if (!validate({ name, stock, price, categoryName, category, image })) {
      return
    }

    // submit
    validationErrors.value = null

    const formData = new FormData()
    formData.append('name', name)
    formData.append('price', price)
    formData.append('stock', stock)
    if (categoryName.length > 0) {
      formData.append('categoryname', categoryName)
    } else {
      formData.append('category', category)
    }
    formData.append('image', image)
    loading.value = true
    const response = await addProduct(formData)
    loading.value = false

    // handle response
    if (isAxiosError(response)) {
      if (response.response?.data.errors) {
        validationErrors.value = response.response?.data.errors
      } else {
        createError.value = response
      }
    } else {
      success.value = true
    }
  }

  return {
    createProduct,
    createError,
    loading,
    success,
    validationErrors,
  }
}
