<script setup lang="ts">
import { computed, onBeforeMount, ref, watchEffect } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { storeToRefs } from 'pinia'

import { useAuthStore } from './stores/authStore'
import { redirectIfLoggedIn } from './utils/helpers'

import DefaultLayout from './layouts/DefaultLayout.vue'
import ErrorBoundary from './components/ErrorBoundary.vue'
import RouterGuard from './router/RouterGuard.vue'

const router = useRouter()
const route = useRoute()
const authStore = useAuthStore()
const { isLoggedIn } = storeToRefs(authStore)

const isReady = ref(false)

// lifecycle hooks
onBeforeMount(async () => {
  await authStore.checkSessionAuthenticated()

  isReady.value = true
})

const routeName = computed(() => route.name)

watchEffect(() => {
  redirectIfLoggedIn(router, routeName.value as string | undefined | null, isLoggedIn.value)
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
