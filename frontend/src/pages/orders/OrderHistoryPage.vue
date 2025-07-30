<script setup lang="ts">
import { onMounted, ref } from 'vue'
import BaseTable from '../../components/table/BaseTable.vue'
import { generatePaginationData, getDateFromString, getFormattedNumber } from '../../utils/helpers'
import instance from '../../utils/axios'
import { useAuthStore } from '../../stores/authStore'
import ErrorBoundary from '../../components/ErrorBoundary.vue'
import { OrderType, PaginationData } from '../../types'
import Pagination from '../../components/Pagination.vue'
import LoadingComponent from '../../components/LoadingComponent.vue'

const authStore = useAuthStore()
const orders = ref<OrderType[]>([])
const pagination = ref<PaginationData | null>(null)
const loading = ref(false)

function showOrderItemsSummary(order: OrderType) {
  return order.order_items.map((oi) => `${oi.product.name}-<b>(${oi.item_count})</b>`).join(', ')
}

async function fetchOrders(page: number = 1) {
  loading.value = true
  const response = await instance.get(`/users/${authStore.user?.id}/orders?page=${page}`)
  loading.value = false

  orders.value = response.data.data
  pagination.value = generatePaginationData(response) as PaginationData
}

onMounted(async () => {
  await fetchOrders()
})
</script>

<template>
  <section id="main">
    <h3>My Order History</h3>
    <div class="table-viewport">
      <ErrorBoundary :is-page="false">
        <LoadingComponent v-if="loading" />
        <BaseTable v-else class="rounded stripped">
          <template #caption>These are the orders you have placed with us</template>
          <template #thead>
            <th>#</th>
            <th>Order Number</th>
            <th>Order Summary</th>
            <th>Status</th>
            <th>Amount</th>
            <th>Delivery Info</th>
          </template>
          <template #tbody>
            <tr v-for="(order, idx) in orders" :key="order.id">
              <td>{{ idx + 1 }}.</td>
              <td class="center">{{ order.order_no }}</td>
              <td class="center" style="font-weight: 400; word-wrap: normal" v-html="showOrderItemsSummary(order)" />
              <td class="center text-sm" style="text-transform: uppercase">{{ order.status }}</td>
              <td class="right">{{ getFormattedNumber(order.total) }}</td>
              <td class="center" style="">
                {{
                  order.actual_delivery_date
                    ? 'Delivered - ' + getDateFromString(order.actual_delivery_date)
                    : 'To Be Delivered - ' + getDateFromString(order.expected_delivery_date)
                }}
              </td>
            </tr>
          </template>
        </BaseTable>
        <div v-if="!!pagination" class="paginator">
          <Pagination :meta="pagination" :pagination-handler="fetchOrders" />
        </div>
      </ErrorBoundary>
    </div>
  </section>
</template>

<style scoped>
section#main {
  padding: 1rem;
}

h3 {
  text-align: center;
}

.table-viewport {
  width: min(100%, 1024px);
  margin-inline: auto;
}

tbody > tr > td:nth-of-type(2) {
  word-break: normal;
  word-wrap: normal;
  min-width: 160px;
  padding-inline: 0.2rem;
  max-width: 250px;
}

div.paginator {
  width: inherit;
  display: flex;
  align-items: center;
  justify-content: flex-end;
  margin-top: 1.5rem;
}
</style>
