<script setup lang="ts">
import { PropType } from 'vue'

type NotificationType = 'success' | 'info' | 'error'

defineProps({
  type: {
    type: String as PropType<NotificationType>,
    required: false,
    default: 'info',
  },
})
</script>

<template>
  <div :class="type">
    <slot name="message">Something happened. Check console logs.</slot>
  </div>
</template>

<style scoped>
.success {
}
.info {
}
.error {
}
</style>
