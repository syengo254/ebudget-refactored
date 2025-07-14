<script setup lang="ts">
import { computed, PropType } from 'vue'
import ErrorBoundary from '../../../components/ErrorBoundary.vue'
import { getFormattedNumber } from '../../../utils/helpers'
import { useCartStore } from '../../../stores/cartStore'

const props = defineProps({
  cartItemId: {
    required: true,
    type: String as PropType<string | number>,
  },
})

const cart = useCartStore()

const cartItem = cart.getItemById(props.cartItemId)
const isStocked = computed(() => cartItem.product.stock_amount > 0)
</script>
<template>
  <ErrorBoundary :is-page="false">
    <div class="cart-product">
      <div class="image">
        <img :src="cartItem.product.image" :alt="cartItem.product.name + ' image'" />
      </div>
      <div class="description">
        <div class="name">
          <p>{{ cartItem.product.name }}</p>
        </div>
        <div :class="'stock-info ' + (isStocked ? 'green' : 'red')">
          <span>{{ isStocked ? 'In Stock' : 'Out Of Stock' }}</span>
        </div>
        <div class="actions">
          <div class="buttons">
            <button @click="cart.removeItem(cartItemId)">-</button>
            <span>{{ cartItem.count }}</span>
            <button @click="cart.addItem(cartItem.product)">+</button>
          </div>
          <a href="#" class="text-sm decoration-none" @click.prevent="cart.removeItem(cartItemId, true)">Delete</a>
        </div>
      </div>
      <div class="costing">
        <div class="total bold">{{ getFormattedNumber(cartItem.count * cartItem.product.price) }}</div>
        <div class="item-price text-sm">
          <span>Per item: {{ getFormattedNumber(cartItem.product.price, 'decimal') }}</span>
        </div>
      </div>
    </div>
  </ErrorBoundary>
</template>

<style scoped>
.cart-product {
  display: flex;
  flex-direction: row;
  height: fit-content;
  border-bottom: 1px solid rgb(210, 210, 210);
  margin-bottom: 1rem;
}

.cart-product > div.image > img {
  height: 200px;
  width: 200px;
  object-fit: fill;
  margin: 0.5rem 1rem 0rem 0rem;
}

.cart-product > div.description {
  flex-grow: 1;
  height: 190px;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  margin-left: 1rem;
}

.description p {
  margin: 0.25rem 0;
}

.name {
  font-size: 1.3rem;
  font-weight: 400;
}

.total {
  font-size: 1.2rem;
}

.item-price {
  color: rgb(59, 59, 59);
  margin-top: 0.5rem;
}

.actions {
  display: flex;
  flex-direction: row;
  column-gap: 1rem;
  align-items: center;
}

.actions > a {
  display: block;
  height: 1rem;
  margin-block: 0.2rem;
  padding-left: 0.5rem;
  border-left: 1px solid rgb(190, 190, 190);
  color: rgb(25, 95, 165);
}

.actions > a:hover {
  text-decoration: underline;
}

.actions > .buttons {
  display: flex;
  flex-direction: row;
  align-items: center;
  gap: 1rem;
  border: 2px solid orange;
  padding: 0.2rem 1.5rem;
  border-radius: 1.5rem;
  font-weight: 500;
}

.actions > .buttons > button {
  border: none;
  outline: none;
  background: none;
  font-weight: 400;
  font-family: 'Roboto', sans-serif;
  font-size: 1.2rem;
  cursor: pointer;
}
.stock-info {
  font-size: 0.9rem;
  margin-bottom: auto;
  margin-top: 1rem;
}

.stock-info.green {
  color: rgb(2, 155, 104);
}
.stock-info.red {
  color: orangered;
}
</style>
