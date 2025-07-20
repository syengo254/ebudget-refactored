<script setup lang="ts">
defineProps({
  image: {
    type: String,
    required: true,
  },
})
</script>

<template>
  <div class="product-extra-images">
    <div class="item">
      <img :src="image" alt="product-image-1" />
    </div>
    <div class="item">
      <img :src="image" alt="product-image-1" />
    </div>
    <div class="item">
      <img :src="image" alt="product-image-1" />
    </div>
    <div class="item">
      <img :src="image" alt="product-image-1" />
    </div>
    <div class="item">
      <img :src="image" alt="product-image-1" />
    </div>
  </div>
</template>

<style scoped>
.product-extra-images {
  max-width: 110px;
}

.product-extra-images > .item {
  width: calc(80px + 0.5rem);
  height: calc(80px + 0.5rem);
  border: 1px solid gray;
  padding: 0.25rem;
  margin-bottom: 0.5rem;
}

.product-extra-images > .item > img {
  width: 75px;
  height: 75px;
  cursor: pointer;
}
</style>
