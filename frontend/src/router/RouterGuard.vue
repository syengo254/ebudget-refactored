<script lang="ts" setup>
import { storeToRefs } from 'pinia'
import { useRouter } from 'vue-router'

import { useAuthStore } from '../stores/authStore'

const router = useRouter()
const authStore = useAuthStore()

router.beforeEach(async (to, from, next) => {
  document.title = typeof to.meta.title === 'string' ? to.meta.title : 'E-budget.com | Best Online Shoping Experience'

  if (to.meta.requiresAuth) {
    await authStore.checkSessionAuthenticated((to.meta.forceCheckServerAuth as boolean) ?? false)

    const { isLoggedIn } = storeToRefs(authStore)

    if (!isLoggedIn.value) {
      return next('login')
    }
  }

  return next()
})
</script>

<template>
  <slot />
</template>
