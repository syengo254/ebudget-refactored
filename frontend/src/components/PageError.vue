<script setup lang="ts">
import { ref, onErrorCaptured } from 'vue'

const hasError = ref(false)
const errorMessage = ref('')

onErrorCaptured((err, instance, info) => {
  hasError.value = true
  errorMessage.value = err.message // Or a more user-friendly message

  // eslint-disable-next-line no-console
  console.error('Error captured by ErrorBoundary:', err, instance, info)

  // Return false to stop the error from propagating further
  return false
})
</script>

<template>
  <div v-if="hasError">
    <h3>Sorry, An Error Occured</h3>
    <p>It seems we are experiencing an issue with the site. Try reloading the page.</p>
    <h5>More Details:</h5>
    <p>{{ errorMessage }}</p>
    <div>
      <button>Reload</button>
    </div>
  </div>
  <slot v-else />
</template>
