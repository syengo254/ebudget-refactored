<script setup lang="ts">
import { ref } from 'vue'
import { getFormattedNumber } from '../../../utils/helpers'

const priceFilter = ref(120000)
</script>

<template>
  <div class="categories">
    <section class="category-section">
      <h4 class="category-heading">Popular categories</h4>
      <div class="category-body">
        <ul>
          <li>
            <a href="#">Furniture</a>
          </li>
          <li>
            <a href="#">Furniture</a>
          </li>
          <li>
            <a href="#">Furniture</a>
          </li>
          <li>
            <a href="#">Furniture</a>
          </li>
        </ul>
      </div>
      <div class="category-footer">
        <a href="#">See more</a>
      </div>
    </section>

    <section class="filters-section">
      <h4>Price range</h4>
      <div class="range-value semibold">{{ getFormattedNumber(100) }} - {{ getFormattedNumber(priceFilter) }}</div>
      <div class="range-input">
        <input v-model="priceFilter" type="range" name="price" min="100" max="1000000" step="200" />
        <button class="btn go-btn">Go</button>
      </div>
    </section>
  </div>
</template>

<style scoped>
div.categories {
  min-width: calc(300px - 1rem);
  margin: 1.5rem 1rem 0 0;
  color: rgb(34, 34, 34);
}

section.category-section {
  border-bottom: 1px solid black;
  font-size: 0.95rem;
  padding-bottom: 1rem;
}

section.filters-section {
  font-size: 0.95rem;
  padding-bottom: 1rem;
}

section.category-section a {
  font-size: 0.95rem;
}

h4.category-heading {
  margin: 0;
  margin-bottom: 0.5rem;
}

.category-body ul {
  padding: 0;
  margin: 0;
  list-style: none;
}

.category-body ul > li {
  padding-block: 0.1rem;
}

.category-body a {
  color: inherit;
  text-decoration: none;
  transition: color linear 100ms;
}
.category-body a:hover {
  color: rgb(197, 128, 0);
}

.category-footer a {
  text-decoration: none;
  transition: color linear 100ms;
  margin-top: 0.25rem;
  display: block;
}

.category-footer a:hover {
  color: rgb(14, 14, 105);
}

input[type='range'] {
  width: 100%;
}

.go-btn {
  font-weight: 600;
  font-size: medium;
  padding: 0.4rem 0.5rem;
  border-radius: 14px;
  border: 1px solid rgb(74, 74, 74);
  outline: none;
}

.range-value {
  font-size: 0.9rem;
  margin-bottom: 0.2rem;
}

@media screen and (max-width: 800px) {
  div.categories {
    display: none;
  }
}
</style>
