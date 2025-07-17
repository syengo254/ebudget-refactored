<script lang="ts" setup>
import { RouteLocationNamedRaw, useRouter } from 'vue-router'
import { resolve } from './middleware'

const router = useRouter()

router.beforeEach((to, from, next) => {
  document.title = typeof to.meta.title === 'string' ? to.meta.title : 'E-budget.com | Best Online Shoping Experience'

  const guards: string[] = Array.isArray(to.meta.guards) ? to.meta.guards : []

  if (guards.length > 0) {
    let failPath: RouteLocationNamedRaw = {}
    const validated = guards.every((guard) => {
      const [success, routeTo] = resolve(guard, to)
      failPath = routeTo
      return success
    })

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
