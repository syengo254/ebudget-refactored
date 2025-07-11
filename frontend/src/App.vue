<script setup lang="ts">
import { onBeforeMount, ref } from 'vue'

import { useAuthStore } from './stores/authStore'

import DefaultLayout from './layouts/DefaultLayout.vue'
import ErrorBoundary from './components/ErrorBoundary.vue'
import RouterGuard from './router/RouterGuard.vue'

const authStore = useAuthStore()

const isReady = ref(false)

// lifecycle hooks
onBeforeMount(async () => {
  await authStore.checkSessionAuthenticated()

  isReady.value = true
})
</script>

<template>
  <ErrorBoundary>
    <RouterGuard>
      <DefaultLayout v-if="isReady">
        <router-view />
      </DefaultLayout>
    </RouterGuard>
  </ErrorBoundary>
</template>
