<script setup lang="ts">
import { ref, onErrorCaptured, watch } from 'vue'
import { useRoute } from 'vue-router'

const hasError = ref(false)
const errorMessage = ref('')

const route = useRoute()

onErrorCaptured((err, instance, info) => {
  hasError.value = true
  errorMessage.value = err.message // Or a more user-friendly message

  // eslint-disable-next-line no-console
  console.error('Error captured by ErrorBoundary:', err, instance, info)

  // Return false to stop the error from propagating further
  return false
})

function reload() {
  window.location.reload()
}

watch(
  hasError,
  (val) => {
    if (val) {
      document.title = 'ERROR: E-budget.com | We are sorry, an error has ocurred on the current page.'
    } else {
      document.title = (route.meta.title as string) ?? 'E-budget.com | Best Online Shoping Experience'
    }
  },
  { deep: true },
)
</script>

<template>
  <div v-if="hasError" class="error-boundary">
    <header>
      <h2>E-budget.com</h2>
      <nav>
        <a href="/">Home</a>
      </nav>
    </header>
    <section>
      <div class="error-box">
        <h3 class="title">Oops! Something wrong has happened</h3>
        <div class="body">
          <p>We are sorry that you are having problems with the site.</p>
          <div class="error-details semibold">
            <p>{{ errorMessage }}</p>
          </div>
          <div>
            <button class="btn" @click="reload">Reload Page</button>
          </div>
        </div>
      </div>
    </section>
  </div>
  <slot v-else>
    <!-- content goes here -->
  </slot>
</template>

<style scoped>
div.error-boundary > header {
  position: relative;
  width: 100%;
  height: 65px;
  display: flex;
  justify-content: space-between;
  padding: 0.5rem 3rem;
  background: rgb(30, 45, 125);
  color: white;
  align-items: center;
  z-index: 2;
}

div.error-boundary > header a {
  color: white;
  text-decoration: none;
}

div.error-box {
  position: relative;
  margin-inline: auto;
  margin-top: 5rem;
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
