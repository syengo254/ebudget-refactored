<script setup lang="ts">
defineProps<{
  show: boolean
  msg: string
}>()
</script>

<template>
  <div v-show="show" class="alert error mt-1 block semibold">
    <p>{{ msg }}</p>
  </div>
</template>
