<script setup lang="ts">
import BaseButton from '../components/buttons/BaseButton.vue'
</script>

<template>
  <div class="mb-1">
    <BaseButton variant="primary" size="sm">Small</BaseButton>
    <BaseButton variant="primary">Medium</BaseButton>
    <BaseButton variant="primary" disabled>Disabled</BaseButton>
    <BaseButton variant="primary" size="lg">Large</BaseButton>
  </div>
  <div class="mb-1">
    <BaseButton variant="danger" size="sm">Small</BaseButton>
    <BaseButton variant="danger">Medium</BaseButton>
    <BaseButton variant="danger" disabled>Disabled</BaseButton>
    <BaseButton variant="danger" size="lg">Large</BaseButton>
  </div>
  <div class="mb-1">
    <BaseButton variant="secondary" size="sm">Small</BaseButton>
    <BaseButton variant="secondary">Medium</BaseButton>
    <BaseButton variant="secondary" disabled>Disabled</BaseButton>
    <BaseButton variant="secondary" class="rounded-lg" size="lg">Large</BaseButton>
  </div>
  <div class="mb-1">
    <BaseButton variant="success" size="sm">Small</BaseButton>
    <BaseButton variant="success">Medium</BaseButton>
    <BaseButton variant="success" disabled>Disabled</BaseButton>
    <BaseButton variant="success" class="rounded-lg" size="lg">Large</BaseButton>
  </div>
  <div class="mb-1">
    <BaseButton size="sm">Small</BaseButton>
    <BaseButton>Medium</BaseButton>
    <BaseButton disabled>Disabled</BaseButton>
    <BaseButton size="lg">Large</BaseButton>
  </div>
</template>

<style scoped></style>
