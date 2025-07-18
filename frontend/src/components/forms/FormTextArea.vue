<script setup lang="ts">
const modelValue = defineModel<string>()

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
})
</script>

<template>
  <label v-if="label !== ''" :for="name">{{ label }}</label>
  <textarea :id="name" v-model="modelValue" class="form-input" v-bind="$attrs" />
  <slot />
</template>

<style scoped>
label {
  color: rgba(0, 0, 0, 0.85);
  font-size: 0.9rem;
}
</style>
