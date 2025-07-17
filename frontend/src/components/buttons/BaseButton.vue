<script setup lang="ts">
import { PropType, ref } from 'vue'

const props = defineProps({
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
  variant: {
    type: String as PropType<'primary' | 'error' | 'info'>,
    required: false,
    default: 'primary',
  },
})

const variantClasses = {
  primary: 'btn-primary',
  error: 'btn-error',
  info: 'btn-info',
}

const classes = ref('btn ' + variantClasses[props.variant])
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
  color: white;
  cursor: pointer;
  font-weight: 600;
}
</style>
