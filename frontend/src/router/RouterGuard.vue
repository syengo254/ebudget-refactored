<script lang="ts" setup>
import { RouteLocationNamedRaw, useRouter } from 'vue-router'
import { resolve } from './middleware'

const router = useRouter()

router.beforeEach(async (to, from, next) => {
  document.title = typeof to.meta.title === 'string' ? to.meta.title : 'E-budget.com | Best Online Shoping Experience'

  const guards: string[] = Array.isArray(to.meta.guards) ? to.meta.guards : []

  if (guards.length > 0) {
    let failPath: RouteLocationNamedRaw = {}
    let validated = true // Initialize as true, similar to how .every works
    for (let i = 0; i < guards.length; i++) {
      const guard = guards[i]
      const [success, routeTo] = await resolve(guard, to)
      if (!success) {
        validated = false
        failPath = routeTo // Update failPath only if a guard fails
        break // Exit the loop early as soon as one guard fails
      }
    }

    if (validated) {
      next()
    } else {
      if (failPath.name === 'back') {
        next(from.path)
      } else {
        next(failPath)
      }
    }
  } else {
    next()
  }
})
</script>

<template>
  <slot />
</template>
