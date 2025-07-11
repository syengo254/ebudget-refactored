<script setup lang="ts">
//
</script>

<template>
  <div class="group-header">
    <h2>
      <slot>
        <!-- heading here -->
      </slot>
    </h2>
  </div>
</template>

<style scoped>
div.group-header > h2 {
  font-size: 1.3rem;
  margin: 0;
  padding: 0.5rem 0.5rem;
}
</style>
