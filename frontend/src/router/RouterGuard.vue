<script lang="ts" setup>
import { useRouter } from 'vue-router'

import { useAuthStore } from '../stores/authStore'

const router = useRouter()
const authStore = useAuthStore()

router.beforeEach(async (to, _from, next) => {
  document.title = typeof to.meta.title === 'string' ? to.meta.title : 'E-budget.com | Best Online Shoping Experience'

  if (to.meta.requiresAuth) {
    await authStore.checkSessionAuthenticated(to.meta.forceCheckServerAuth ? true : false)
    if (authStore.isLoggedIn) {
      if (to.meta.requiresVerified && !authStore.user?.verified) {
        next({
          path: 'verify-account',
          query: { redirect: to.fullPath },
        })
      } else {
        next()
      }
    } else {
      next({
        name: 'login',
        query: { redirect: to.fullPath },
      })
    }
  } else if (to.meta.requiresGuest) {
    if (authStore.isLoggedIn) {
      next('/')
    } else {
      next()
    }
  } else {
    next()
  }
})
</script>

<template>
  <slot />
</template>
