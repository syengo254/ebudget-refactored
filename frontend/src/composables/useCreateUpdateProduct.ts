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

export default function useCreateUpdateProduct() {
  const { addProduct, updateProduct } = useProducts()
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

  function validate({ productId, name, stock, price, categoryName, category, image }: CreateProductType): boolean {
    // console.table({ productId, name, stock, price, categoryName, category, image })
    // validate
    if (name.length < 8) {
      validationErrors.value = {
        name: ['Name should be a minimum of 8 characters'],
      }
      return false
    }
    if (price < 10) {
      validationErrors.value = {
        price: ['Price minimum should be KES 10'],
      }
      return false
    }
    if (stock < 3) {
      validationErrors.value = {
        stock: ['Stock minimum should be 3'],
      }
      return false
    }
    if (categoryName === '' && category === '') {
      validationErrors.value = {
        category: ['You must select or add a category'],
      }
      return false
    }
    if (!image && !productId) {
      validationErrors.value = {
        image: ['You must set the product image'],
      }
      return false
    }

    if (image && image.size > 1000 * 1000 * 5) {
      validationErrors.value = {
        image: ['Image size cannot be more than 5MB'],
      }
      return false
    }

    return true
  }

  async function createOrUpdateProduct({
    productId,
    name,
    stock,
    price,
    categoryName,
    category,
    image,
  }: CreateProductType) {
    if (!validate({ productId, name, stock, price, categoryName, category, image })) {
      return
    }

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
    if (productId) {
      formData.append('id', String(productId))
    }
    if (image) {
      formData.append('image', image)
      if (productId) formData.append('imageHasChanged', '1')
    }

    let response = null

    loading.value = true
    response = !productId ? await addProduct(formData) : await updateProduct(productId, formData)
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
