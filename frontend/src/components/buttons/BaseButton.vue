<script setup lang="ts">
import { PropType } from 'vue'

const props = defineProps({
  type: {
    type: String as PropType<'submit' | 'button'>,
    required: false,
    default: 'button',
  },
  variant: {
    type: String as PropType<'primary' | 'danger' | 'success' | 'secondary' | 'outlined' | 'default'>,
    required: false,
    default: 'default',
  },
  size: {
    type: String as PropType<'sm' | 'md' | 'lg'>,
    required: false,
    default: 'md',
  },
})

const variantClasses = {
  primary: 'btn-primary',
  danger: 'btn-danger',
  success: 'btn-success',
  secondary: 'btn-secondary',
  outlined: 'btn-outlined',
  default: 'btn-default',
}

const sizes = {
  sm: 'sm rounded-sm',
  md: 'rounded',
  lg: 'lg rounded-lg',
}

const classes = (variantClasses[props.variant] + ' ' + sizes[props.size]).trim()
</script>

<template>
  <button :type="type" :class="classes">
    <slot>
      <!-- slot -->
    </slot>
  </button>
</template>

<style scoped>
/* button base */
button {
  font-family: 'Roboto', sans-serif;
  font-size: 1rem;
  width: fit-content;
  padding: 0.4rem 1rem;
  background: rgb(240, 240, 240);
  color: rgb(53, 53, 53);
  outline: none;
  border: 1px solid rgb(200, 200, 200);
  transition: 0.5s;
  font-weight: 500;
  cursor: pointer;
}

/* variants */

.btn-primary {
  background: rgb(37, 82, 205);
  border: 1px solid rgb(31, 69, 176);
  color: white;
}

.btn-primary:hover {
  background: rgb(33, 74, 189);
}

.btn-danger {
  background-color: rgb(239, 92, 38);
  border: 1px solid red;
  color: white;
}

.btn-danger:hover {
  background-color: rgb(224, 83, 32);
}

.btn-secondary {
  background: #f2f2f2;
  border: 1px solid rgb(226, 226, 226);
  color: rgb(156, 39, 176);
}

.btn-secondary:hover {
  background: rgb(245, 233, 248);
}

.btn-success {
  background: rgb(92, 184, 92);
  border: 1px solid rgb(61, 133, 61);
  color: white;
}

.btn-success:hover {
  background: rgb(83, 171, 83);
}
/* variants */

/* sizes */

button.sm {
  padding: 0.25rem 0.6rem;
  font-family: 'Roboto', sans-serif;
  font-weight: 500;
  font-size: 0.9rem;
}

button.lg {
  padding: 0.6rem 1.4rem;
  font-family: 'Roboto', sans-serif;
  font-weight: 500;
  font-size: 1.1rem;
}

/* sizes */

/* disabled */
button:disabled {
  cursor: not-allowed;
}

/* rounded */
button.rounded-sm {
  border-radius: 3.5px;
}
button.rounded {
  border-radius: 5px;
}
button.rounded-lg {
  border-radius: 8.5px;
}
</style>
