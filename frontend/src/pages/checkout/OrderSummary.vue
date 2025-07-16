<script setup lang="ts">
import { RouterLink } from 'vue-router'
import SuccessAlert from '../../components/SuccessAlert.vue'
import ErrorAlert from '../../components/ErrorAlert.vue'
import { getFormattedNumber } from '../../utils/helpers'
import { useCartStore } from '../../stores/cartStore'

defineEmits(['placeOrder'])
defineProps<{
  deliveryFees: number
  loading: boolean
  error: boolean | Error
  message: string
  success: boolean
  successMessage: string
}>()

const cartStore = useCartStore()
</script>

<template>
  <div class="order-summary-viewport">
    <div v-if="success" class="order-response">
      <SuccessAlert :show="success" :msg="successMessage" :show-tick="true">
        <div class="text-center">
          <RouterLink :to="{ name: 'products' }">Continue shopping</RouterLink>
        </div>
      </SuccessAlert>
    </div>
    <div v-else class="order-summary">
      <h3>Order Summary</h3>
      <div class="line">
        <div class="label">Items total ({{ cartStore.count }})</div>
        <div class="cost">{{ getFormattedNumber(cartStore.subtotal) }}</div>
      </div>
      <div class="line">
        <div class="label">Delivery fees</div>
        <div class="cost">{{ getFormattedNumber(deliveryFees) }}</div>
      </div>
      <div class="line totals">
        <div class="label">Total</div>
        <div class="cost">{{ getFormattedNumber(deliveryFees + cartStore.subtotal) }}</div>
      </div>
      <div>
        <button class="btn block btn-orange" :disabled="loading" @click="$emit('placeOrder')">
          {{ loading ? 'Please wait...' : 'Place Order' }}
        </button>
        <div style="margin: 0.5rem; text-align: center">
          <div style="margin-bottom: 0.5rem">or</div>
          <RouterLink :to="{ name: 'shopping-cart' }" class="text-sm decoration-none hover-underline"
            >Modify cart</RouterLink
          >
        </div>
      </div>
      <ErrorAlert :show="!!error" :msg="message" />
    </div>
  </div>
</template>

<style scoped>
.order-summary-viewport {
  position: relative;
  background: white;
  margin: 1rem;
  max-height: 360px;
  padding: 1rem;
  min-width: 300px;
  color: rgb(52, 52, 52);
}
.order-summary > h3 {
  margin: 0;
  margin-bottom: 1rem;
  font-weight: 500;
}
.btn-orange {
  background: rgb(242, 126, 2);
  color: white;
  border: 1px solid rgb(218, 114, 3);
}
.btn-orange:hover {
  background: rgb(223, 115, 0);
  color: white;
  border: 1px solid rgb(218, 114, 3);
}
.order-summary > .line {
  display: flex;
  flex-wrap: nowrap;
  align-items: center;
  justify-content: space-between;
  margin-block: 1rem;
}
.label {
  font-size: 0.9rem;
}
.cost {
  font-size: 0.95rem;
  font-weight: 500;
}
.line.totals {
  padding-block: 0.75rem;
  border-top: 1px solid rgb(212, 212, 212);
  border-bottom: 1px solid rgb(212, 212, 212);
}
.line.totals > .label {
  font-size: 1rem;
  font-weight: 500;
}
.line.totals > .cost {
  font-size: 1.1rem;
  font-weight: 500;
}
@media screen and (max-width: 700px) {
  .order-summary {
    width: 100%;
  }
}
</style>
