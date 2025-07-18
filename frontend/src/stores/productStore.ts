import { defineStore } from 'pinia'
import { CategoryType, ProductsFiltersType, ProductType } from '../types'
import useProducts from '../composables/useProducts'
import { MAX_CACHED_PAGES } from '../config'
import { AxiosError } from 'axios'

export interface ProductStoreType {
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
    getProducts(state): ProductType[] {
      return state.products
    },
    getCategories(state): CategoryType[] {
      return state.categories
    },
    getFilters(state) {
      return Object.entries(state.filters).map(([key, value]) => {
        return {
          name: key,
          value,
        }
      })
    },
    hasFilters(state) {
      return Object.keys(state.filters).length > 0
    },
  },

  actions: {
    async fetchProducts(noCache: boolean = false, page?: number) {
      const { fetch } = useProducts()

      if (page && this.page !== page) {
        this.page = page
      }

      if (!noCache && this.cachedProducts[this.page]) {
        this.loading = true
        this.products = this.cachedProducts[this.page].data
        this.pagination = this.cachedProducts[this.page].pagination
        this.loading = false
        return
      }

      this.loading = true
      const results = await fetch(page, this.filters)
      this.loading = false

      if (results instanceof AxiosError || results instanceof Error) {
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

    //
    async getOrFetch(productId: number) {
      const product = this.products.find((p) => p.id == productId)

      if (product) {
        return product
      }

      const response = await useProducts().fetchProduct(productId)
      return response.data as ProductType
    },
    //

    async fetchCategories(noCache: boolean = false) {
      if (!noCache && this.getCategories.length > 1) return
      const { fetchCategories: fetch } = useProducts()

      const response = await fetch()

      if (response instanceof AxiosError || response instanceof Error) {
        this.categories = [
          {
            id: -1,
            name: 'Failed to fetch categories, please reload the page: ' + response.message,
          },
        ]
      } else {
        this.categories = response
      }
    },

    invalidateCache() {
      this.cachedProducts = {}
    },

    removeFilter(filterName: keyof ProductsFiltersType) {
      const filters = this.filters
      delete filters[filterName]
      this.filters = filters
      this.invalidateCache()
      ;(async () => {
        await this.fetchProducts(true, 1)
      })()
    },

    async clearFilters() {
      this.filters = {}
      this.invalidateCache()

      await this.fetchProducts(false, 1)
    },

    addFilter(filterName: keyof ProductsFiltersType, filterValue: ProductsFiltersType[keyof ProductsFiltersType]) {
      this.filters[filterName] = filterValue as never
      ;(async () => {
        await this.fetchProducts(true, 1)
      })()
    },
  },
})
