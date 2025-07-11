<script setup lang="ts">
//
</script>

<template>
  <div class="group-container">
    <slot name="header" />
    <slot name="body" />
    <slot name="footer" />
  </div>
</template>

<style scoped>
.group-container {
  background-color: rgb(222, 222, 222);
  padding-block: 1rem;
}
</style>
