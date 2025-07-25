<script setup lang="ts">
import { computed, onMounted, ref } from 'vue'
import { getFormattedNumber } from '../../../utils/helpers'
import useVendor from '../../../composables/useVendor'
import { useAuthStore } from '../../../stores/authStore'
import { ProductType } from '../../../types'
import { isAxiosError } from 'axios'
import LoadingComponent from '../../../components/LoadingComponent.vue'
import ErrorComponent from '../../../components/ErrorComponent.vue'

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
        <table class="sales-table rounded stripped">
          <caption class="text-sm">
            <p style="margin: 0; margin-bottom: 0.5rem; font-style: italic">
              These are the products ordered from your store this week
            </p>
          </caption>
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Product</th>
              <th scope="col">Items Ordered</th>
              <th scope="col" class="right">Price Per Item</th>
              <th scope="col" class="right">Sub-total</th>
              <th scope="col">Date Ordered</th>
              <th scope="col">Expected Delivery Date</th>
              <th scope="col">Order Status</th>
            </tr>
          </thead>
          <tbody>
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
          </tbody>
          <tfoot>
            <tr>
              <th scope="row" colspan="2" class="center">Totals</th>
              <td class="center">{{ getTableTotalItems(orders) }}</td>
              <td v-if="orders.length > 0" colspan="2" class="right">
                {{ getFormattedNumber(getTableTotalAmount(orders)) }}
              </td>
              <td colspan="3" class="right">
                <!-- just to hold -->
              </td>
            </tr>
          </tfoot>
        </table>
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
/* Table Styles */
table {
  min-width: 900px;
  width: 100%;
  border-collapse: collapse;
}

table.rounded thead th:first-of-type {
  border-top-left-radius: 10px;
}
table.rounded thead th:last-of-type {
  border-top-right-radius: 10px;
}
table.rounded tfoot tr:last-of-type th:first-of-type {
  border-bottom-left-radius: 10px;
}
table.rounded tfoot tr:last-of-type td:last-of-type {
  border-bottom-right-radius: 10px;
}

table.stripped > tbody > tr:nth-child(even) {
  background-color: #f3f4ff;
}

thead > tr {
  background-color: var(--bg-blue);
  color: white;
}

tfoot > tr {
  background-color: var(--bg-light-blue);
  color: white;
}

thead > tr > th {
  font-size: 1rem;
  font-weight: 500;
  padding: 0.4rem 0.8rem;
  width: auto;
}

tfoot > tr > th,
tfoot > tr > td {
  font-size: 1rem;
  font-weight: 600;
  padding: 0.3rem 0.8rem;
  width: auto;
  text-transform: uppercase;
}

tbody > tr > td {
  padding: 0.4rem 0.6rem;
  font-size: 0.92rem;
  letter-spacing: 0.3px;
}

/* tbody > tr > td:first-of-type {
  border-left: 1px solid var(--bg-light-blue);
}
tbody > tr > td:last-of-type {
  border-right: 1px solid var(--bg-light-blue);
} */

tbody > tr > td:nth-of-type(2) {
  word-break: normal;
  word-wrap: normal;
  min-width: 160px;
  padding-inline: 0.2rem;
  max-width: 400px;
}

th.right,
td.right {
  text-align: right;
}

th.center,
td.center {
  text-align: center;
}

th.left,
td.left {
  text-align: left;
}
</style>
