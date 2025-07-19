<script setup lang="ts">
import { PropType } from 'vue'
import { RouterLink, useRouter } from 'vue-router'

import { ProductType } from '../types'
import { getFormattedNumber } from '../utils/helpers'
import { useAuthStore } from '../stores/authStore'

const { product } = defineProps({
  product: {
    required: true,
    type: Object as PropType<ProductType>,
  },
})

const router = useRouter()
const emit = defineEmits(['addToCart'])

const authStore = useAuthStore()

function handleAddToCart() {
  emit('addToCart')
}
function navigateToProduct() {
  router.push({
    name: 'view-product',
    params: {
      id: product.id,
    },
  })
}
</script>

<template>
  <div class="product-card">
    <div class="product-image">
      <img :src="product.image" :alt="product.name + '-image'" class="image" @click="navigateToProduct" />
      <img class="store-icon" :src="product.store?.logo" alt="store-logo" />
    </div>
    <div class="product-info">
      <div class="product-desc">
        <span class="muted-text" style="margin-bottom: 0.5rem; display: block"
          ><a href="#" class="decoration-none" :data-id="product.category?.name">{{ product.category?.name }}</a></span
        >
        <p>
          <RouterLink :to="'/products/' + product.id">{{ product.name }}</RouterLink>
        </p>
      </div>
      <div class="product-price">{{ getFormattedNumber(product.price) }}/=</div>
      <div class="store-info">
        <p class="text-sm">
          Available at:
          <RouterLink :to="'/products/store/' + product.store?.id">{{
            product.store?.name ?? 'Ebudget.com'
          }}</RouterLink>
        </p>
      </div>
      <div v-show="!authStore.hasStore" class="buy-btn">
        <button class="add-cart-btn" @click="handleAddToCart">Add to cart</button>
      </div>
    </div>
  </div>
</template>

<style scoped>
.product-card {
  position: relative;
  background-color: rgb(248, 248, 248);
  width: 240px;
  height: fit-content;
  border: 1px solid rgb(237, 237, 237);
  padding-bottom: 0.5rem;
}

.product-card:hover {
  box-shadow: 1px 1px 3px 1px rgb(209, 209, 209);
}

.product-card > .product-image {
  position: relative;
  background-color: rgb(240, 240, 240);
  max-height: 238px;
  cursor: pointer;
}

.product-card > .product-image > img.store-icon {
  position: absolute;
  height: 64px;
  width: 64px;
  object-fit: scale-down;
  border: 1px solid rgb(234, 234, 234);
  z-index: 3;
  right: calc(0 - 48px);
  top: -1px;
  right: -1px;
  background: white;
  opacity: 0.9;
}

.product-card > .product-image > img.image {
  position: relative;
  width: 238px;
  height: 238px;
  object-fit: fill;
  padding: 0.5rem;
}

.product-info {
  position: relative;
  display: flex;
  flex-direction: column;
  row-gap: 0.8em;
  padding: 0.5rem;
}

.product-info > .product-desc {
  max-height: fit-content;
}

.product-info > .product-desc > p {
  overflow: hidden;
  text-overflow: ellipsis;
  display: -webkit-box;
  -webkit-line-clamp: 3;
  line-clamp: 3;
  -webkit-box-orient: vertical;
  line-height: 1.5rem;
  margin: 0;
}

.product-info > .product-desc > p > a {
  color: inherit;
  text-decoration: none;
  transition: color linear 100ms;
}

.product-info > .product-desc > p > a:hover {
  color: inherit;
  text-decoration: none;
  color: rgb(51, 97, 224);
}

button.add-cart-btn {
  outline: none;
  border: none;
  background-color: rgb(51, 97, 224);
  color: white;
  padding: 0.5rem 1rem;
  border-radius: 14px;
  cursor: pointer;
}

.product-price {
  font-size: 1.5rem;
  font-weight: bold;
  display: block;
}

.store-info > p {
  margin: 0;
}

.store-info > p > a {
  text-decoration: none;
  color: rgb(51, 97, 224);
  /* color: rgb(246, 160, 2); */
}

.store-info > p > a:hover {
  text-decoration: underline;
}

button.add-cart-btn:hover {
  background-color: rgb(52, 76, 212);
}

@media screen and (max-width: 420px) {
  .product-card {
    position: relative;
    background-color: rgb(248, 248, 248);
    flex-grow: 1;
    width: 98vw;
    /* height: fit-content; */
    border: 1px solid rgb(237, 237, 237);
    cursor: pointer;
    padding-bottom: 0.65rem;
  }
  .product-card > .product-image {
    position: relative;
    background-color: rgb(240, 240, 240);
    width: calc(98vw - 1rem);
  }

  .product-card > .product-image > img {
    position: relative;
    width: calc(98vw - 2 * 6rem);
    object-fit: fill;
  }
}
</style>
