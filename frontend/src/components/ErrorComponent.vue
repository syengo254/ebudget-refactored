<script setup lang="ts">
const props = defineProps<{
  action: () => void
  error: { message?: string } | null
  actionName?: string
}>()
</script>

<template>
  <div class="error-box">
    <h3>A component error occured</h3>
    <div class="body">
      <p>Here are the details:</p>
      <div class="error-details">
        <p>{{ error?.message }}</p>
      </div>
      <button type="button" class="btn" @click="() => props.action()">{{ props.actionName ?? 'Retry' }}</button>
    </div>
  </div>
</template>

<style scoped>
div.error-box {
  position: relative;
  margin-inline: auto;
  margin-top: 1rem;
  border: 1px solid rgb(30, 45, 125);
  max-width: 600px;
  display: flex;
  flex-direction: column;
}

.error-box h3 {
  text-align: center;
  background-color: rgb(30, 45, 125);
  color: white;
  margin: 0;
  padding: 1rem 2rem;
}

.error-box div.body {
  padding: 1.2rem;
  text-align: center;
}
div.error-details {
  background-color: rgb(251, 215, 215);
  padding: 0.5rem;
  font-size: 0.9rem;
  color: rgb(227, 103, 103);
  line-height: 1rem;
}

.body button.btn {
  color: rgb(30, 45, 125);
  margin-top: 2rem;
}
</style>
