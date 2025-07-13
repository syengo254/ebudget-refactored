<script setup lang="ts">
import { onMounted, onUnmounted, ref } from 'vue'
import FormCheckbox from '../../components/forms/FormCheckbox.vue'
import Error from '../../components/forms/Error.vue'
import checkIcon from '@/assets/check.png'
import { useAuthStore } from '../../stores/authStore'
import { RouterLink } from 'vue-router'

const useActiveAddress = ref(true)
const cashPayment = ref(true)
const prevBgColor = ref('')

const authStore = useAuthStore()

onMounted(() => {
  prevBgColor.value = document.body.style.backgroundColor
  document.body.style.backgroundColor = 'rgb(234, 234, 234)'
})

onUnmounted(() => {
  document.body.style.backgroundColor = prevBgColor.value
})

// handlers
function handlePlaceOrder() {
  //
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
            <FormCheckbox v-model="useActiveAddress" type="radio" name="active_address" label="Use Active Address">
              <Error :form-errors="[]" />
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
            <FormCheckbox v-model="cashPayment" type="radio" name="cash_payment" label="Cash On Delivery" />
          </div>
          <div class="form-group">
            <FormCheckbox type="radio" name="mpesa_payment" label="Pay with M-PESA" :disabled="true" />
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
    <div class="order-summary">
      <h3>Order Summary</h3>
      <div class="line">
        <div class="label">Items total (1)</div>
        <div class="cost">KES 2,000</div>
      </div>
      <div class="line">
        <div class="label">Delivery fees</div>
        <div class="cost">KES 250</div>
      </div>
      <div class="line totals">
        <div class="label">Total</div>
        <div class="cost">KES 2,250</div>
      </div>
      <div>
        <button class="btn block btn-orange" @click="handlePlaceOrder">Place Order</button>
      </div>
    </div>
  </section>
</template>

<style scoped>
/* Order summary */
.order-summary {
  position: relative;
  background: white;
  margin: 1rem;
  max-height: 255px;
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
