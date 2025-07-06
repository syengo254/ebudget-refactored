<script setup lang="ts">
import { PropType } from 'vue'
import { RouterLink } from 'vue-router'

import { ProductType } from '../types'
import { getFormattedNumber } from '../utils/helpers'

import imgSrc from '@/assets/colgate-toothpaste.jpg'

defineProps({
  product: {
    required: true,
    type: Object as PropType<ProductType>,
  },
})
</script>

<template>
  <div class="product-card">
    <div class="product-image">
      <img :src="imgSrc" :alt="product.name + '-image'" />
    </div>
    <div class="product-info">
      <div class="product-desc">
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
      <div class="buy-btn">
        <button class="add-cart-btn">Add to cart</button>
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
  cursor: pointer;
  padding-bottom: 0.5rem;
}

.product-card:hover {
  box-shadow: 1px 1px 3px 1px rgb(209, 209, 209);
}

.product-card > .product-image {
  position: relative;
  background-color: rgb(240, 240, 240);
  max-height: 238px;
}

.product-card > .product-image > img {
  position: relative;
  max-width: 238px;
  object-fit: cover;
}

.product-info {
  position: relative;
  display: flex;
  flex-direction: column;
  row-gap: 0.8em;
  padding: 0.5rem;
}

.product-info > .product-desc {
  max-height: 70px;
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

@media screen and (max-width: 400px) {
  .product-card {
    position: relative;
    background-color: rgb(248, 248, 248);
    width: 200px;
    height: fit-content;
    border: 1px solid rgb(237, 237, 237);
    cursor: pointer;
    padding-bottom: 0.65rem;
  }
  .product-card > .product-image {
    position: relative;
    background-color: rgb(240, 240, 240);
    max-height: 198px;
  }

  .product-card > .product-image > img {
    position: relative;
    max-width: 198px;
    object-fit: cover;
  }
}
</style>
