<script setup lang="ts">
import ErrorBoundary from '../../components/ErrorBoundary.vue'
import { useCartStore } from '../../stores/cartStore'
import { getFormattedNumber } from '../../utils/helpers'
import CartProduct from './components/CartProduct.vue'

const cart = useCartStore()

function handleCheckout() {}
</script>

<template>
  <ErrorBoundary :is-page="false">
    <section id="main">
      <div class="page-viewport">
        <h2>Shopping Cart</h2>
        <hr />
        <div v-if="cart.hasItems" class="cart-product-viewport">
          <CartProduct v-for="id in cart.getItemsIds" :key="id + 'in-cart'" :cart-item-id="id" />
        </div>
        <div v-else class="cart-product-viewport">
          <p>Your cart is empty</p>
          <RouterLink class="decoration-none hover-underline" :to="{ name: 'products' }">Continue shopping</RouterLink>
        </div>
      </div>
      <div class="cart-totals text-center">
        <h3>Subtotal</h3>
        <div class="sub-total-text">{{ getFormattedNumber(cart.subtotal) }}</div>
        <div>({{ cart.count }} items)</div>
        <button @click="handleCheckout">Proceed to checkout</button>
      </div>
    </section>
  </ErrorBoundary>
</template>

<style scoped>
section#main {
  position: relative;
  background-color: rgb(224, 224, 224);
  width: 100%;
  height: inherit;
  margin: 0;
  /* border: 1px solid rgb(190, 190, 190); */
  display: flex;
  flex-wrap: wrap;
}
.page-viewport,
.cart-totals {
  position: relative;
  background: white;
  margin: 1rem;
  padding: 1rem 1.5rem;
}

.page-viewport {
  flex-grow: 1;
}

/* cart totals */
.cart-totals {
  width: 300px;
  max-height: 220px;
}

.cart-totals > h3 {
  font-weight: 500;
  font-size: 1.5rem;
  margin: 0.5rem 0.5rem;
  color: rgb(41, 41, 41);
}

.sub-total-text {
  color: black;
  font-weight: 500;
  font-size: 1.6rem;
  margin: 0.6rem 0rem 0.8rem 0rem;
}

div.cart-totals > button {
  padding: 0.5rem 2.2rem;
  background: rgb(242, 126, 2);
  color: white;
  font-family: 'Roboto', sans-serif;
  font-weight: 500;
  font-size: 1.1rem;
  margin-top: 1rem;
  cursor: pointer;
  outline: none;
  border: 1px solid rgb(242, 126, 2);
  border-radius: 21rem;
}
/* end cart totals */

hr {
  border: none;
  border-bottom: 1px solid rgb(210, 210, 210);
  background: none;
}

.cart-product-viewport {
  display: flex;
  flex-direction: column;
}
</style>
