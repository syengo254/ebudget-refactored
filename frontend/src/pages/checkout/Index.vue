<script setup lang="ts">
import { onMounted, onUnmounted, ref } from 'vue'
import FormCheckbox from '../../components/forms/FormCheckbox.vue'
import Error from '../../components/forms/Error.vue'
import checkIcon from '@/assets/check.png'
import { RouterLink, useRouter } from 'vue-router'
import LoadingComponent from '../../components/LoadingComponent.vue'
import CheckoutCard from './CheckoutCard.vue'
import OrderSummary from './OrderSummary.vue'
import useCheckout from '../../composables/useCheckout'

const {
  useActiveAddress,
  cashPayment,
  validationErrors,
  deliveryFees,
  authStore,
  cartStore,
  success,
  error,
  message,
  loading,
  handlePlaceOrder,
} = useCheckout()

const router = useRouter()
const prevBgColor = ref('')
const pageReady = ref(false)

onMounted(() => {
  if (cartStore.count == 0) {
    router.push('/products')
  }
  prevBgColor.value = document.body.style.backgroundColor
  document.body.style.backgroundColor = 'rgb(234, 234, 234)'
  setTimeout(() => {
    pageReady.value = true
  }, 600)
})

onUnmounted(() => {
  document.body.style.backgroundColor = prevBgColor.value
})
</script>

<template>
  <Suspense>
    <template #default>
      <section v-if="pageReady" id="main">
        <div class="order-viewport">
          <h3>Place your order</h3>
          <hr />
          <CheckoutCard title="1. Delivery Address" :icon="checkIcon">
            <div class="default-address px-1">
              <div class="form-group">
                <FormCheckbox v-model="useActiveAddress" name="active_address" label="Use Active Address">
                  <Error :form-errors="validationErrors.address" />
                </FormCheckbox>
              </div>
            </div>
            <div v-show="!authStore.user?.address" class="add-address">
              <RouterLink :to="{ name: 'profile' }">Add Address</RouterLink>
            </div>
          </CheckoutCard>
          <CheckoutCard title="2. Payment Option" :icon="checkIcon">
            <div class="payment-option px-1 pb-1">
              <div class="form-group">
                <FormCheckbox v-model="cashPayment" name="cash_payment" label="Cash On Delivery">
                  <Error :form-errors="validationErrors.payment" />
                </FormCheckbox>
              </div>
              <div class="form-group">
                <FormCheckbox name="mpesa_payment" label="Pay with M-PESA" :disabled="true" />
              </div>
            </div>
          </CheckoutCard>
          <CheckoutCard title="3. Delivery details" :icon="checkIcon">
            <div class="delivery-option px-1">
              <p>Your order will be delivered between 1-3 days from today.</p>
            </div>
          </CheckoutCard>
        </div>
        <OrderSummary
          :delivery-fees="deliveryFees"
          :loading="loading"
          :error="error"
          :message="message"
          :success="success"
          :success-message="message"
          @place-order="handlePlaceOrder"
        />
      </section>
    </template>
    <template #fallback>
      <LoadingComponent v-if="!pageReady" />
    </template>
  </Suspense>
</template>

<style scoped>
/* Order summary */
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
/* order summary end */

section#main {
  position: relative;
  background-color: rgb(234, 234, 234);
  width: 100%;
  min-height: 300px;
  margin: 0;
  /* border: 1px solid rgb(190, 190, 190); */
  display: flex;
  flex-wrap: wrap;
}
.order-viewport {
  position: relative;
  background: white;
  margin: 1rem;
  min-height: 300px;
  flex-grow: 1;
  padding-bottom: 1rem;
}

.order-viewport,
.order-summary {
  border-radius: 3.5px;
}

h3 {
  text-align: center;
}

h5 {
  font-size: 1rem;
  margin: 1rem 0;
}

div.heading {
  display: flex;
  align-items: center;
  flex-wrap: nowrap;
  column-gap: 0.5rem;
  padding-left: 1rem;
}

div.heading > div.is-ok {
  width: 20px;
  height: 20px;
}
div.heading > div.is-ok > img {
  width: 20px;
  height: 20px;
}

.checkout-card {
  border-bottom: 1px solid rgb(234, 234, 234);
}

hr {
  border: none;
  border-bottom: 1px solid rgb(210, 210, 210);
  background: none;
}

.add-address {
  display: inline-block;
  margin: 0.8rem 1.5rem;
  font-size: 0.9rem;
}

.delivery-option > p {
  color: rgb(62, 62, 62);
  font-style: italic;
  font-weight: 400;
}
</style>
