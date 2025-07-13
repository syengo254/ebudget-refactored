<script setup lang="ts">
import { useRouter } from 'vue-router'
import { useCartStore } from '../../../stores/cartStore'
import { getFormattedNumber } from '../../../utils/helpers'

const router = useRouter()
const shoppingCart = useCartStore()

function handleGotoCart() {
  router.push('/shopping-cart')
}
</script>
<template>
  <div class="ads-cart-subtotal-viewport">
    <div v-show="shoppingCart.hasItems" class="cart-preview text-center">
      <h4>Subtotal</h4>
      <div class="sub-total-text">{{ getFormattedNumber(shoppingCart.subtotal) }}</div>
      <div class="text-sm">({{ shoppingCart.count }} items)</div>
      <button class="btn btn-outlined" @click="handleGotoCart">Go to Cart</button>
    </div>
    <div id="promotions-panel">
      <p>Ads and promotions go here</p>
    </div>
  </div>
</template>

<style>
.ads-cart-subtotal-viewport {
  border-left: 1px solid rgb(223, 223, 223);
  padding: 0.5rem 1rem;
  margin-left: auto;
}

.cart-preview > h4 {
  font-weight: 400;
  margin: 0.5rem 0.5rem;
}

.sub-total-text {
  color: rgb(242, 126, 2);
  font-weight: 700;
  font-size: 1.2rem;
  margin: 0.6rem 0rem 0.8rem 0rem;
}

div.cart-preview > button {
  padding: 0.3rem 2.2rem;
}

@media screen and (max-width: 600px) {
  .ads-cart-subtotal-viewport {
    display: none;
  }
}
</style>
