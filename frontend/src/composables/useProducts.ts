// using a composable will enable refetch function, retries on error & error handling and caching
import axios from '../utils/axios'
import { getProducts } from '../services/products'
import { CategoryType, ProductsFiltersType } from '../types'

export default function useProducts() {
  async function fetchProducts(page: number = 1, filters: ProductsFiltersType = {}) {
    try {
      const { data, meta } = await getProducts(page, filters)
      return { data, meta }
    } catch (err) {
      return err as Error
    }
  }

  async function fetchCategories() {
    try {
      const response = await axios.get('/categories')
      return response.data as CategoryType[]
    } catch (err) {
      return err as Error
    }
  }

  return {
    fetch: fetchProducts,
    fetchCategories,
  }
}
