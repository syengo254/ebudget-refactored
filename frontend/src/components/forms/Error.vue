<script setup lang="ts">
import { PropType } from 'vue'

const props = defineProps({
  formErrors: {
    type: Array as PropType<string[]>,
    required: true,
    default: () => [],
  },
})
</script>

<template>
  <div class="muted-text error">
    <ul v-if="props.formErrors">
      <li v-for="err in props.formErrors" :key="err">{{ err }}</li>
    </ul>
  </div>
</template>
