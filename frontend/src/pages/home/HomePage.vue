<script setup lang="ts">
import { RouterLink } from 'vue-router'

import imgSrc from '../../assets/colgate-toothpaste.jpg'
</script>

<template>
  <h4>Our products</h4>

  <div id="products-root">
    <div v-for="n in 28" :key="n" class="product-card">
      <div class="product-image">
        <img :src="imgSrc" alt="" />
      </div>
      <div class="product-info">
        <div class="product-desc">
          <p><RouterLink to="#">Colgate fresh toothpaste 300ml</RouterLink></p>
        </div>
        <div class="product-price">KES 120.00/=</div>
        <div class="buy-btn">
          <button class="add-cart-btn">Add to cart</button>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
#products-root {
  position: relative;
  display: flex;
  flex-direction: row;
  flex-wrap: wrap;
  gap: 1rem;
  margin-bottom: 5rem;
  width: fit-content;
  margin-inline: auto;
  align-items: center;
}
.product-card {
  position: relative;
  background-color: rgb(248, 248, 248);
  width: 240px;
  height: 400px;
  border: 1px solid rgb(237, 237, 237);
  cursor: pointer;
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

button.add-cart-btn:hover {
  background-color: rgb(52, 76, 212);
}
</style>
