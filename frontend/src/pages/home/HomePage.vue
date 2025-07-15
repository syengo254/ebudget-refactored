<script setup lang="ts">
import { computed, onMounted, ref } from 'vue'
import ProductGroupView from '../../components/products/ProductGroupView.vue'
import { useProductStore } from '../../stores/productStore'
import { formatString, getRandomNumber } from '../../utils/helpers'

const productStore = useProductStore()

const randomSalutes = [
  '{0}',
  'Your favorite {0}',
  'We have your favorite {0}',
  'Do not worry about {0}',
  'You can find {0} here',
  'Checkout our collection of {0}',
]

function getRandomSalute() {
  return randomSalutes[getRandomNumber(randomSalutes.length)]
}
onMounted(async () => {
  await productStore.fetchCategories(true)
})

const displayCount = ref(5)

const categoriesToShow = computed(() => {
  return productStore.getCategories.slice(0, displayCount.value)
})
</script>

<template>
  <ProductGroupView
    v-for="category in categoriesToShow"
    :key="category.name"
    :heading="formatString(getRandomSalute(), category.name)"
    :grouping="{ key: 'category', name: category.name }"
  />
  <!-- This is the home page -->
</template>

<style scoped></style>
