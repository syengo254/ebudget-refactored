<script setup lang="ts">
import { computed, onBeforeMount, ref, watchEffect } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { storeToRefs } from 'pinia'

import { useAuthStore } from './stores/authStore'
import { redirectIfLoggedIn } from './utils/helpers'

import DefaultLayout from './layouts/DefaultLayout.vue'

const router = useRouter()
const route = useRoute()
const authStore = useAuthStore()
const { isLoggedIn: isSignedIn } = storeToRefs(authStore)

const isReady = ref(false)

// lifecycle hooks
onBeforeMount(async () => {
  await authStore.checkSessionAuthenticated()

  isReady.value = true
})

const routeName = computed(() => route.name)

watchEffect(() => {
  redirectIfLoggedIn(router, routeName.value as string | undefined | null, isSignedIn.value)
})

authStore.$subscribe(
  () => {
    return authStore.updateLocalSessionStorage()
  },
  { flush: 'sync' },
)
</script>

<template>
  <div v-if="isReady">
    <DefaultLayout>
      <router-view />
    </DefaultLayout>
  </div>
</template>
