<script setup lang="ts">
import checkIcon from '@/assets/check.png'

defineProps<{
  show: boolean
  msg: string
  showTick?: boolean
}>()
</script>

<template>
  <div v-show="show" class="alert success mt-1 block">
    <p>{{ msg }}</p>
  </div>
  <div v-if="showTick && show" style="text-align: center; margin: 1rem">
    <img :src="checkIcon" alt="" style="max-width: 96px" />
  </div>
  <slot />
</template>
