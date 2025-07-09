<script lang="ts" setup>
const modelValue = defineModel<string>()

defineProps({
  type: {
    type: String,
    required: false,
    default: 'text',
  },
  name: {
    type: String,
    required: true,
  },
  label: {
    type: String,
    required: false,
    default: '',
  },
  placeholder: {
    type: String,
    required: false,
    default: '',
  },
  autocomplete: {
    type: String,
    required: false,
    default: 'off',
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
})
</script>

<template>
  <label v-if="label !== ''" :for="name">{{ label }}</label>
  <input
    :id="name"
    v-model="modelValue"
    :type="type"
    class="form-input"
    :autocomplete="autocomplete"
    :placeholder="placeholder"
    :disabled="disabled"
    :required="required"
  />
  <slot>
    <!-- errors slot -->
  </slot>
</template>

<style scoped>
label {
  color: rgba(0, 0, 0, 0.85);
  font-size: 0.9rem;
}
</style>
