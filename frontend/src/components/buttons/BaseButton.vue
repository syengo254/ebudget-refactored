<script setup lang="ts">
import { PropType } from 'vue'

const props = defineProps({
  type: {
    type: String as PropType<'submit' | 'button'>,
    required: false,
    default: 'button',
  },
  disabled: {
    type: Boolean,
    required: false,
    default: false,
  },
  variant: {
    type: String as PropType<'primary' | 'error' | 'info' | 'secondary' | 'outlined'>,
    required: false,
    default: 'primary',
  },
})

const variantClasses = {
  primary: 'btn-primary',
  error: 'btn-error',
  info: 'btn-info',
  secondary: 'btn-secondary',
  outlined: 'btn-outlined',
}

const classes = 'btn ' + variantClasses[props.variant]
</script>

<template>
  <button :type="type" :class="classes" :disabled="disabled">
    <slot>
      <!-- slot -->
    </slot>
  </button>
</template>

<style scoped>
button[type='submit'],
button[type='button'] {
  font-weight: 600;
  outline: none;
}
</style>
