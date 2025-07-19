<script setup lang="ts">
import { PropType } from 'vue'
import { BreadcrumpItemType } from '../types'

defineProps({
  items: {
    type: Array as PropType<BreadcrumpItemType[]>,
    required: true,
  },
})
</script>

<template>
  <div class="breadcrump">
    <ul>
      <li v-for="item in items" :key="item.item">
        <a v-if="item.link" :href="item.link" class="decoration-none">{{ item.item }}</a>
        <span v-else>{{ item.item }}</span>
      </li>
    </ul>
  </div>
</template>

<style scoped>
.breadcrump {
  position: relative;
  width: inherit;
  margin: 0.5rem 1rem;
}

.breadcrump > ul {
  display: flex;
  flex-wrap: wrap;
  column-gap: 0.2rem;
  row-gap: 0.3rem;
  margin: 0;
  padding: 0;
  list-style: none;
}

.breadcrump > ul > li {
  font-size: 0.8rem;
  letter-spacing: 0.5px;
}

.breadcrump > ul > li::after {
  content: '>';
  margin-inline: 0.2rem;
  pointer-events: none;
  text-decoration: none !important;
}

.breadcrump > ul > li:last-child::after {
  content: '';
}

.breadcrump > ul > li > a,
.breadcrump > ul > li > span {
  color: rgb(53, 53, 53);
  cursor: pointer;
}

.breadcrump > ul > li > a:hover,
.breadcrump > ul > li > span:hover {
  text-decoration: underline;
}
</style>
