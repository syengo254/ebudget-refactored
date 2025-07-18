import { defineStore } from 'pinia'
import { computed, ref } from 'vue'
import { CategoryType, ProductType } from '../types'
import { AxiosError, isAxiosError } from 'axios'
import useProducts from '../composables/useProducts'
import instance from '../utils/axios'

interface VendorState {
  products: ProductType[]
  categories: CategoryType[]
  orders: string[]
  paginationData: Record<string, unknown>
  error: AxiosError | Error | null
}

export const useVendorStore = defineStore('vendor', () => {
  const catalog = ref<VendorState>({
    products: [],
    paginationData: {},
    categories: [],
    orders: [],
    error: null,
  })

  const vendorSummary = ref({
    total_products: 0,
    sales_this_week: 0,
    returned_products: 0,
    sales_amount: 0,
  })

  const vendorProducts = computed(() => catalog.value.products)

  async function fetchVendorProducts(vendorName: string, page: number = 1) {
    const { fetch } = useProducts()
    const response = await fetch(page, { store: vendorName })

    if (!isAxiosError(response)) {
      catalog.value.products = response.data
      catalog.value.paginationData = response.meta
    } else {
      catalog.value.error = response
    }
  }

  async function fetchSummary(storeID: number) {
    const response = await instance.get('/stores/' + storeID + '/summary')

    if (response.status === 200) {
      vendorSummary.value = response.data.counts
    }
  }

  return {
    catalog,
    vendorProducts,
    fetchVendorProducts,
    vendorSummary,
    fetchSummary,
  }
})
