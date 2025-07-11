<script setup lang="ts">
import { PropType } from 'vue'
import { RouterLink } from 'vue-router'

import { ProductType } from '../types'
import { getFormattedNumber } from '../utils/helpers'

defineProps({
  product: {
    required: true,
    type: Object as PropType<Partial<ProductType>>,
  },
})
</script>

<template>
  <div class="product-card">
    <div class="product-image">
      <img :src="product.image" :alt="product.name + '-image'" class="image" />
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
      <div class="product-price">From {{ getFormattedNumber(product.price || 0) }}</div>
      <div class="store-info">
        <p class="text-sm">
          Available at:
          <RouterLink :to="'/products/store/' + product.store?.id">{{
            product.store?.name ?? 'Ebudget.com'
          }}</RouterLink>
        </p>
      </div>
    </div>
  </div>
</template>

<style scoped>
.product-card {
  position: relative;
  /* background-color: rgb(248, 248, 248); */
  width: 210px;
  height: fit-content;
  /* border: 1px solid rgb(237, 237, 237); */
  cursor: pointer;
  padding-bottom: 0.2rem;
}

.product-card > .product-image {
  position: relative;
  height: 208px;
}

.product-card > .product-image > img.image {
  position: relative;
  width: 208px;
  height: 208px;
  object-fit: fill;
}

.product-card:hover {
  box-shadow: 1px 1px 4px 2px rgb(209, 209, 209);
}

.product-info {
  position: relative;
  display: flex;
  flex-direction: column;
  row-gap: 0.5em;
  padding: 0.5rem;
}

.product-info > .product-desc {
  max-height: fit-content;
}

.product-info > .product-desc > p {
  overflow: hidden;
  text-overflow: ellipsis;
  display: -webkit-box;
  -webkit-line-clamp: 1;
  line-clamp: 1;
  -webkit-box-orient: vertical;
  line-height: 1.2rem;
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

.product-price {
  font-size: 1rem;
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
