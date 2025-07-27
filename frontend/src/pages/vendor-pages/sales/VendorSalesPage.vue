<script setup lang="ts">
import { computed, onMounted, ref } from 'vue'
import { getFormattedNumber } from '../../../utils/helpers'
import useVendor from '../../../composables/useVendor'
import { useAuthStore } from '../../../stores/authStore'
import { ProductType } from '../../../types'
import { isAxiosError } from 'axios'
import LoadingComponent from '../../../components/LoadingComponent.vue'
import ErrorComponent from '../../../components/ErrorComponent.vue'
import BaseTable from '../../../components/table/BaseTable.vue'

// type
export interface SaleItem {
  id: number
  order_id: number
  product_id: number
  item_count: number
  price_at_order: number
  created_at: string
  product: ProductType
  order: Order
}

export interface Order {
  id: number
  status: string
  expected_delivery_date: string
}

// end type

const authStore = useAuthStore()
const { getVendorOrders } = useVendor(authStore.user?.store?.id as number)
const orders = ref<SaleItem[]>([])
const error = ref(false)
const loading = ref(false)

const hasData = computed(() => orders.value.length > 0)

onMounted(async () => {
  await loadSales()
})

async function loadSales() {
  loading.value = true
  error.value = false
  const data = await getVendorOrders()
  loading.value = false
  if (isAxiosError(data) || data instanceof Error) {
    error.value = true
  } else {
    orders.value = data
  }
}

function getTableTotalAmount(items: SaleItem[]) {
  return items.reduce((prev: number, curr: SaleItem) => {
    return prev + curr.item_count * curr.price_at_order
  }, 0)
}

function getTableTotalItems(items: SaleItem[]) {
  return items.reduce((prev: number, curr: SaleItem) => {
    return prev + curr.item_count
  }, 0)
}
</script>

<template>
  <section id="main">
    <h3>Sales This Week</h3>
    <ErrorComponent v-show="error" :error="{ message: 'Failed to load, please try again' }" :action="loadSales" />
    <LoadingComponent v-show="loading" />
    <div v-if="!loading && !error" class="table-viewport">
      <div v-if="!hasData">
        <p class="muted-text text-center">You have no sales this week. Consider advertising with us?</p>
      </div>
      <div v-else class="table-section">
        <div class="table-funcs">
          <!-- things like filter and export buttons -->
        </div>
        <BaseTable class="sales-table rounded stripped">
          <template #caption> These are the products ordered from your store this week </template>
          <template #thead>
            <th scope="col">#</th>
            <th scope="col">Product</th>
            <th scope="col">Items Ordered</th>
            <th scope="col" class="right">Price Per Item</th>
            <th scope="col" class="right">Sub-total</th>
            <th scope="col">Date Ordered</th>
            <th scope="col">Expected Delivery Date</th>
            <th scope="col">Order Status</th>
          </template>
          <template #tbody>
            <tr v-for="(sale, index) in orders" :key="sale.id + 'sale-item'">
              <td>{{ index + 1 }}.</td>
              <td scope="row" class="center">{{ sale.product.name }}</td>
              <td class="center">{{ sale.item_count }}</td>
              <td class="right">{{ getFormattedNumber(sale.price_at_order, 'decimal') }}</td>
              <td class="right">{{ getFormattedNumber(sale.price_at_order * sale.item_count, 'decimal') }}</td>
              <td class="center">{{ new Date(sale.created_at).toDateString() }}</td>
              <td class="center">{{ new Date(sale.order.expected_delivery_date).toDateString() }}</td>
              <td class="center" style="text-transform: uppercase">{{ sale.order.status }}</td>
            </tr>
          </template>
          <template #tfoot>
            <th scope="row" colspan="2" class="center">Totals</th>
            <td class="center">{{ getTableTotalItems(orders) }}</td>
            <td v-if="orders.length > 0" colspan="2" class="right">
              {{ getFormattedNumber(getTableTotalAmount(orders)) }}
            </td>
            <td colspan="3" class="right">
              <!-- just to hold -->
            </td>
          </template>
        </BaseTable>
      </div>
    </div>
  </section>
</template>

<style scoped>
#main {
  padding: 0.5rem 1rem;
  width: 100%;
}

h3 {
  margin: 0.8rem;
  text-align: center;
  width: 100%;
}

.table-viewport {
  overflow-x: scroll;
}

tbody > tr > td:nth-of-type(2) {
  word-break: normal;
  word-wrap: normal;
  min-width: 160px;
  padding-inline: 0.2rem;
  max-width: 400px;
}
</style>
