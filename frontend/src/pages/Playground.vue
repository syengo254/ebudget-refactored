<script setup lang="ts">
import BaseButton from '../components/buttons/BaseButton.vue'
import ToastMessageNotification from '../components/ToastMessageNotification.vue'
import useToast from '../composables/useToast'
const toast = useToast()
</script>

<template>
  <main>
    <ToastMessageNotification variant="warning" />
    <BaseButton variant="success" size="md" class="mt-1" @click="toast.show('meme' + Math.random() * 1000)"
      >Show Toast</BaseButton
    >
  </main>
</template>

<style scoped>
main {
  margin: 1rem;
}
</style>
