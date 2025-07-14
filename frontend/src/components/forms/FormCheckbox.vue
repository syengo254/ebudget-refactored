<script lang="ts" setup>
const modelValue = defineModel<boolean>()

defineProps({
  name: {
    type: String,
    required: true,
  },
  label: {
    type: String,
    required: false,
    default: '',
  },
  disabled: {
    type: Boolean,
    required: false,
    default: false,
  },
  required: {
    type: Boolean,
    required: false,
    default: false,
  },
  style: {
    type: String,
    required: false,
    default: '',
  },
})
</script>

<template>
  <label v-if="label !== ''" :style="style" :for="name">
    <input
      :id="name"
      v-model="modelValue"
      type="checkbox"
      :checked="modelValue"
      class="form-input"
      :disabled="disabled"
      :required="required"
      :style="style"
    />
    {{ label }}</label
  >
  <slot>
    <!-- errors slot -->
  </slot>
</template>

<style scoped>
label {
  color: rgba(0, 0, 0, 0.85);
  font-size: 0.9rem;
  display: flex;
  align-items: center;
  cursor: pointer;
}

input[type='checkbox'] {
  padding: 0.5rem 0.8rem;
  font-family: inherit;
  font-size: 1rem;
  border: 1px solid grey;
  border-radius: 3.5px;
  transform: scale(1.25);
  margin: 0.5rem;
  cursor: pointer;
}
</style>
