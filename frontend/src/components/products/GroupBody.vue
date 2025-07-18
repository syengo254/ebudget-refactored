<script setup lang="ts">
import { onMounted, PropType, ref } from 'vue'

import { GroupingType, ProductType } from '../../types'
import SimpleProductCard from '../SimpleProductCard.vue'
import { getRandomNumber } from '../../utils/helpers'
import { fetchProductsBy } from '../../services/products'
import LoadingComponent from '../LoadingComponent.vue'
import ErrorComponent from '../ErrorComponent.vue'

const randomUnique = 'boostmode' + getRandomNumber(10000)
const products = ref<Partial<ProductType>[]>([])
const error = ref<{ message: string } | null>(null)
const loading = ref(false)

const props = defineProps({
  filter: {
    type: Object as PropType<GroupingType>,
    required: true,
  },
})

onMounted(loadProducts)

async function loadProducts() {
  try {
    loading.value = true
    error.value = null
    const { data } = await fetchProductsBy(props.filter.key, props.filter.name)
    products.value = data
  } catch (err) {
    error.value = {
      message:
        `Failed to fetch products by: ${props.filter.key} - ${props.filter.name}` +
        `More details: ${(err as Error).message}`,
    }
  } finally {
    loading.value = false
  }
}

function scroll(direction: 'left' | 'right') {
  const elem = document.querySelector('#' + String(randomUnique)) as HTMLElement
  const elemWith = parseFloat(getComputedStyle(elem).width)
  if (direction === 'left') {
    elem?.scrollTo(elemWith + elem.scrollLeft, 0)
  } else {
    elem?.scrollTo(elem.scrollLeft - parseFloat(getComputedStyle(elem).width), 0)
  }
}

const reload = async () => await loadProducts()
</script>

<template>
  <div class="group-body">
    <div class="scroller scroller-right" @click="scroll('left')">
      <span>></span>
    </div>
    <div class="scroller scroller-left" @click="scroll('right')">
      <span>&lt;</span>
    </div>
    <LoadingComponent v-if="loading && error == null" />
    <ErrorComponent v-else-if="error" :error="error" :action="reload" action-name="Retry" />
    <div v-else :id="randomUnique" class="group-body-viewport">
      <SimpleProductCard v-for="product in products" :key="product.name" :product="product" />
    </div>
  </div>
</template>

<style scoped>
div.group-body {
  position: relative;
  padding: 0.5rem;
  padding-top: 0;
  min-height: 200px;
}

.group-body-viewport {
  display: flex;
  gap: 1rem;
  overflow-x: auto;
  scroll-behavior: smooth;
  padding-bottom: 0.8rem;
}
div.scroller {
  position: absolute;
  z-index: 6;
  background-color: rgba(255, 255, 255, 0.6);
  width: 40px;
  height: 70px;
  top: calc(40% - 70px / 2);
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  font-weight: bold;
  cursor: pointer;
  transition: background-color linear 200ms;
}

div.scroller:hover {
  background-color: rgba(255, 255, 255, 0.9);
}

div.scroller > span {
  font-weight: 500;
  transform: scaleY(300%) scaleX(150%);
}

.scroller-right {
  right: 0px;
  box-shadow: -1px 1px 3px rgb(162, 162, 162);
}

.scroller-left {
  left: 0px;
  box-shadow: 1px 1px 3px rgb(162, 162, 162);
}
</style>
