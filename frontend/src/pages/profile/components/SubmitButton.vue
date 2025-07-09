<script setup lang="ts">
import { PropType } from 'vue'

defineProps({
  type: {
    type: String as PropType<'submit' | 'button'>,
    required: false,
    default: 'submit',
  },
  disabled: {
    type: Boolean,
    required: false,
    default: false,
  },
})
</script>

<template>
  <button :type="type" class="btn btn-primary" :disabled="disabled">
    <slot>
      <!-- slot -->
    </slot>
  </button>
</template>

<style scoped>
button[type='submit'],
button[type='button'] {
  background-color: blue;
  color: white;
  border: 1px solid blue;
  cursor: pointer;
  font-weight: 600;
}

button[type='submit']:hover,
button[type='button']:hover {
  background-color: rgb(2, 2, 173);
}
</style>
