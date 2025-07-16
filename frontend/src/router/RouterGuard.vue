<script lang="ts" setup>
import { useRouter } from 'vue-router'

import { useAuthStore } from '../stores/authStore'

const router = useRouter()
const authStore = useAuthStore()

router.beforeEach(async (to, _from, next) => {
  document.title = typeof to.meta.title === 'string' ? to.meta.title : 'E-budget.com | Best Online Shoping Experience'

  const guards = Array.isArray(to.meta.guards) ? to.meta.guards : []
  const forceCheckServerAuth = !!to.meta.forceCheckServerAuth

  if (guards.includes('auth')) {
    await authStore.checkSessionAuthenticated(forceCheckServerAuth)
    if (authStore.isLoggedIn) {
      if (guards.includes('verified') && !authStore.user?.verified) {
        next({
          path: 'verify-account',
          query: { redirect: to.fullPath },
        })
      } else if (guards.includes('store')) {
        if (authStore.hasStore) {
          next()
        } else {
          next({
            name: 'home',
            replace: true,
          })
        }
      } else {
        next()
      }
    } else {
      next({
        name: 'login',
        query: { redirect: to.fullPath },
      })
    }
    return
  }

  if (guards.includes('guest')) {
    if (authStore.isLoggedIn) {
      next('/')
    } else {
      next()
    }
    return
  }

  next()
})
</script>

<template>
  <slot />
</template>
