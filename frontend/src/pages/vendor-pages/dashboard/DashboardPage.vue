<script setup lang="ts">
import { RouterLink } from 'vue-router'
import { useAuthStore } from '../../../stores/authStore'
import { getFormattedNumber } from '../../../utils/helpers'
import { onMounted, ref } from 'vue'
import instance from '../../../utils/axios'

const authStore = useAuthStore()
const storeSummary = ref({
  total_products: 0,
  sales_this_week: 0,
  returned_products: 0,
  sales_amount: 0,
})

onMounted(async () => {
  const response = await instance.get('/stores/' + authStore.user?.store?.id + '/summary')

  if (response.status === 200) {
    storeSummary.value = response.data.counts
  }
})
</script>

<template>
  <div class="dashboard-page-viewport">
    <h3 class="dashboard-heading">{{ authStore.user?.store?.name }}'s Dashboard</h3>

    <div class="dashboard-summaries">
      <div class="dashboard-summary-viewport">
        <div class="dashboard-summary-items">
          <ul>
            <li>
              <div class="header">Products Listed</div>
              <div class="body bold">{{ storeSummary.total_products }}</div>
            </li>
            <li>
              <div class="header">Sales This Week</div>
              <div class="body bold">{{ storeSummary.sales_this_week }}</div>
            </li>
            <li>
              <div class="header">Returned Products</div>
              <div class="body bold">{{ storeSummary.returned_products }}</div>
            </li>
            <li>
              <div class="header">Total Sales Amount</div>
              <div class="body bold">{{ getFormattedNumber(storeSummary.sales_amount) }}</div>
            </li>
          </ul>
        </div>
      </div>
    </div>

    <div class="quick-links mt-1">
      <nav>
        <RouterLink :to="{ name: 'profile' }">Edit Store Information</RouterLink>
        <RouterLink :to="{ name: 'my-products' }">My Products</RouterLink>
        <RouterLink to="#" aria-disabled="true">Reports</RouterLink>
      </nav>
    </div>
  </div>
</template>

<style scoped>
h3.dashboard-heading {
  text-align: center;
}

div.dashboard-summaries {
  position: relative;
  width: fit-content;
  margin-inline: auto;
}

div.dashboard-summary-viewport {
  padding: 1rem;
}

div.dashboard-summary-items {
  display: flex;
  flex-wrap: wrap;
}

div.dashboard-summary-items > ul {
  display: flex;
  flex-wrap: wrap;
  gap: 1rem;
  margin: 0;
  padding: 0;
  list-style: none;
}

div.dashboard-summary-items > ul > li {
  max-width: 300px;
  border: 1px solid black;
  border-radius: 3.5px;
}

div.dashboard-summary-items > ul > li > div.header {
  font-size: 1rem;
  text-transform: uppercase;
  padding: 0.5rem 1rem;
}
div.dashboard-summary-items > ul > li > div.body {
  padding: 0.5rem 1rem;
  color: rgb(62, 62, 62);
  font-size: 1.2rem;
}

/* quick links */
.quick-links nav {
  display: flex;
  gap: 2rem;
  justify-content: center;
}
</style>
