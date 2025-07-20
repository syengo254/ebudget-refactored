<script setup lang="ts">
import { computed, PropType } from 'vue'
import { getFormattedNumber } from '../../../utils/helpers'
import { ProductType } from '../../../types'
import { useCartStore } from '../../../stores/cartStore'

const cartStore = useCartStore()

const { product } = defineProps({
  product: {
    type: Object as PropType<ProductType>,
    required: true,
  },
})

const stocked = computed(() => product.stock_amount > 0)
const inCart = computed(() => cartStore.isInCart(product.id))
</script>

<template>
  <div class="product-details">
    <div class="product-name">
      <p>{{ product?.name }}</p>
    </div>
    <div class="product-price">
      <p>{{ getFormattedNumber(product?.price ?? 0) }}</p>
    </div>
    <div v-show="inCart" class="added">Added to cart</div>
    <div class="product-stock text-sm">
      <p v-if="stocked" class="green">
        <span class="semibold">{{ product?.stock_amount }}</span> items in stock
      </p>
      <p v-else class="red">Out of Stock</p>
    </div>
    <div class="store-info">
      <img :src="product?.store?.logo" class="store-icon" alt="store-icon" />
      <p>Available at: {{ product?.store?.name }}</p>
    </div>
  </div>
</template>

<style scoped>
.product-details {
  display: flex;
  flex-direction: column;
  gap: 1rem;
  align-self: center;
  flex-grow: 1;
}

.product-details p {
  margin: 0;
}

.product-name {
  min-width: 400px;
  border-bottom: 1px solid rgb(208, 208, 208);
  margin-bottom: 1rem;
  padding-bottom: 1rem;
  max-width: 700px;
}

.product-name > p {
  font-size: 1.4rem;
  font-weight: 500;
  word-wrap: normal;
}

.product-price > p {
  font-size: 1.1rem;
  color: rgb(50, 50, 50);
  font-weight: 500;
}

.added {
  color: white;
  background: var(--bg-blue);
  width: 120px;
  text-align: center;
  padding: 0.2rem 0.4rem;
  border-radius: 2rem;
}

.green {
  color: rgb(2, 155, 104);
}
.red {
  color: orangered;
}

.store-info {
  display: flex;
  align-items: center;
  column-gap: 0.5rem;
}

.store-info > img {
  width: 53px;
  height: 53px;
  border: 1px solid gray;
  padding: 2px;
}
</style>
