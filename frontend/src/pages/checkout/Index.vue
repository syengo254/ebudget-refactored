<script setup lang="ts">
import { onMounted, onUnmounted, reactive, ref } from 'vue'
import FormCheckbox from '../../components/forms/FormCheckbox.vue'
import Error from '../../components/forms/Error.vue'
import checkIcon from '@/assets/check.png'
import { useAuthStore } from '../../stores/authStore'
import { RouterLink, useRouter } from 'vue-router'
import { useCartStore } from '../../stores/cartStore'
import ErrorAlert from '../../components/ErrorAlert.vue'
import SuccessAlert from '../../components/SuccessAlert.vue'
import { getFormattedNumber } from '../../utils/helpers'

const useActiveAddress = ref(true)
const selectedAddress = ref(false)
const cashPayment = ref(true)
const prevBgColor = ref('')
const validationErrors = reactive<{ address?: string[]; payment?: string[] }>({})
const deliveryFees = 350 // later this will be calculated e.g. send distance to api and the get value back

const authStore = useAuthStore()
const cartStore = useCartStore()

const success = ref(false)
const error = ref<boolean | Error>(false)
const message = ref('')
const loading = ref(false)

const router = useRouter()

onMounted(() => {
  if (cartStore.count == 0) {
    router.push('/products')
  }
  prevBgColor.value = document.body.style.backgroundColor
  document.body.style.backgroundColor = 'rgb(234, 234, 234)'
})

onUnmounted(() => {
  document.body.style.backgroundColor = prevBgColor.value
})

// handlers
async function handlePlaceOrder() {
  validationErrors.address = []
  validationErrors.payment = []

  if (!useActiveAddress.value && !selectedAddress.value) {
    validationErrors.address = ['You have to specify a delivery address.']
    return
  }
  if (!cashPayment.value) {
    validationErrors.payment = ['You have to set a payment option']
    return
  }

  loading.value = true
  const { data, errors } = await cartStore.placeOrder()
  loading.value = false

  if (errors !== null) {
    error.value = errors as Error
    message.value = error.value.message ?? 'Request failed. Please try again later.'
  } else {
    cartStore.clearCart()
    success.value = data.success
    message.value = data.message ?? 'Your order has been placed. We shall contact you for more details.'
  }
}
</script>

<template>
  <section id="main">
    <div class="order-viewport">
      <h3>Place your order</h3>
      <hr />
      <div class="checkout-card">
        <div class="heading">
          <h5>1. Delivery Address</h5>
          <div class="is-ok">
            <img :src="checkIcon" alt="check-success" />
          </div>
        </div>
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
      </div>
      <div class="checkout-card">
        <div class="heading">
          <h5>2. Payment Option</h5>
          <div class="is-ok">
            <img :src="checkIcon" alt="check-success" />
          </div>
        </div>
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
      </div>
      <div class="checkout-card">
        <div class="heading">
          <h5>3. Delivery details</h5>
          <div class="is-ok">
            <img :src="checkIcon" alt="check-success" />
          </div>
        </div>
        <div class="delivery-option px-1">
          <p>Your order will be delivered between 1-3 days from today.</p>
        </div>
      </div>
    </div>
    <!-- order summary -->
    <div class="order-summary-viewport">
      <div v-if="!!error || success" class="order-response">
        <ErrorAlert :show="!!error" :msg="message" />
        <SuccessAlert :show="success" :msg="message" :show-tick="true">
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
          <button class="btn block btn-orange" :disabled="loading" @click="handlePlaceOrder">
            {{ loading ? 'Please wait...' : 'Place Order' }}
          </button>
          <div style="margin: 0.5rem; text-align: center">
            <div style="margin-bottom: 0.5rem">or</div>
            <RouterLink :to="{ name: 'shopping-cart' }" class="text-sm decoration-none hover-underline"
              >Modify cart</RouterLink
            >
          </div>
        </div>
      </div>
    </div>
    <!-- order summary -->
  </section>
</template>

<style scoped>
/* Order summary */
.order-summary-viewport {
  position: relative;
  background: white;
  margin: 1rem;
  max-height: 310px;
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
