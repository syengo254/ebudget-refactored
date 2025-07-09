// using a composable will enable refetch function, retries on error & error handling and caching
import { getProducts } from '../services/products'
import { ProductsFiltersType } from '../types'

export default function useProducts() {
  async function fetch(page: number = 1, filters: ProductsFiltersType = {}) {
    try {
      const { data, meta } = await getProducts(page, filters)
      return { data, meta }
    } catch (err) {
      return err as Error
    }
  }

  return {
    fetch,
  }
}
