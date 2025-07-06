// using a composable will enable refetch function, retries on error & error handling and caching

import { reactive, ref } from 'vue'
import { getAllProducts } from '../services/products'
import { ProductType } from '../types'

export default function useProducts() {
  const error = ref<Error | null>(null)
  const loading = ref(false)
  const products = ref<ProductType[]>([])
  const pagination = reactive({ meta: {} })
  const lastPage = ref(1)

  async function fetch(page: number = 1) {
    lastPage.value = page
    try {
      loading.value = true
      const { data, meta } = await getAllProducts(page)
      products.value = data as ProductType[]
      pagination.meta = meta
    } catch (err) {
      error.value = err as Error
    } finally {
      loading.value = false
    }
  }

  async function refetch(page?: number) {
    error.value = null
    loading.value = false
    products.value = []
    pagination.meta = {}

    await fetch(page ?? lastPage.value)
  }

  ;(async function () {
    await fetch()
  })().then()

  return {
    products,
    refetch,
    loading,
    error,
    pagination,
  }
}
