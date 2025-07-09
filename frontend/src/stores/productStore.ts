import { defineStore } from 'pinia'
import { CategoryType, ProductsFiltersType, ProductType } from '../types'
import useProducts from '../composables/useProducts'
import { MAX_CACHED_PAGES } from '../config'

interface ProductStoreType {
  products: ProductType[]
  cachedProducts: Record<number, { data: ProductType[]; pagination: Record<string, unknown> }>
  categories: CategoryType[]
  filters: ProductsFiltersType
  error?: Error | null
  loading: boolean
  pagination: Record<string, unknown>
  page: number
}

export const useProductStore = defineStore('products', {
  state: (): ProductStoreType => {
    return {
      products: [],
      cachedProducts: {},
      categories: [],
      filters: {},
      loading: false,
      pagination: {},
      page: 1,
    }
  },

  getters: {
    getProducts(): ProductType[] {
      return this.products
    },
    getCategories(): CategoryType[] {
      return this.categories
    },
  },

  actions: {
    async fetchProducts(page?: number) {
      const { fetch } = useProducts()

      if (page && this.page !== page) {
        this.page = page

        if (this.cachedProducts[page]) {
          this.loading = true
          this.products = this.cachedProducts[page].data
          this.pagination = this.cachedProducts[page].pagination
          this.loading = false
          return
        }
      }

      this.loading = true
      const results = await fetch(page, this.filters)
      this.loading = false

      if (results instanceof Error) {
        this.error = results
      } else {
        this.products = results.data
        this.pagination = results.meta

        if (Object.keys(this.cachedProducts).length + 1 > MAX_CACHED_PAGES) {
          // prune first item
          const keys = Object.keys(this.cachedProducts)
          const firstKey = keys.shift()
          if (firstKey !== undefined) {
            delete this.cachedProducts[Number(firstKey)]
          }
        }

        this.cachedProducts[this.page] = {
          data: results.data,
          pagination: results.meta,
        }
      }
    },

    async refetch() {
      if (this.error) this.error = null
      await this.fetchProducts()
    },
  },
})
