<template>
  <div class="checkout-card">
    <div class="heading">
      <h5>{{ title }}</h5>
      <div class="is-ok" v-if="icon">
        <img :src="icon" alt="check-success" />
      </div>
    </div>
    <div>
      <slot />
    </div>
  </div>
</template>

<script setup lang="ts">
defineProps<{ title: string; icon?: string }>()
</script>

<style scoped>
.checkout-card {
  border-bottom: 1px solid rgb(234, 234, 234);
}
.heading {
  display: flex;
  align-items: center;
  flex-wrap: nowrap;
  column-gap: 0.5rem;
  padding-left: 1rem;
}
.heading > .is-ok {
  width: 20px;
  height: 20px;
}
.heading > .is-ok > img {
  width: 20px;
  height: 20px;
}
</style> 