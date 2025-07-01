<script setup lang="ts">
import { onBeforeMount, ref, watchEffect } from 'vue'
import useAuth from './composables/useAuth'
import { useUserStore } from './stores/useUserStore'

import DefaultLayout from './layouts/DefaultLayout.vue'
import useRedirectIfLoggedIn from './composables/useRedirectIfLoggedIn'
import { storeToRefs } from 'pinia'
import { useRoute, useRouter } from 'vue-router'

const router = useRouter()
const route = useRoute()
const { checkAuth } = useAuth()
const userStore = useUserStore()
const { isLoggedIn } = storeToRefs(userStore)

const isReady = ref(false)

// lifecycle hooks
onBeforeMount(async () => {
  const { isLoggedIn, user, error } = await checkAuth()

  if (!error) {
    userStore.setUser(user, isLoggedIn)
  }

  isReady.value = true
})

watchEffect(() => {
  useRedirectIfLoggedIn(router, route.name as string | undefined | null, isLoggedIn.value)
})
</script>

<template>
  <div v-if="isReady">
    <DefaultLayout>
      <router-view />
    </DefaultLayout>
  </div>
</template>
