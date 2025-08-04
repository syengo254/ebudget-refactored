<script lang="ts" setup>
import { RouteLocationNamedRaw, useRouter } from 'vue-router'
import { resolve } from './middleware'
import guardDefinitions from './guards'

const router = useRouter()

router.beforeEach(async (to, from, next) => {
  document.title = typeof to.meta.title === 'string' ? to.meta.title : 'E-budget.com | Best Online Shoping Experience'

  const guards: string[] = Array.isArray(to.meta.guards) ? to.meta.guards : []

  if (guards.length > 0) {
    let result = [true, {}] as [boolean, RouteLocationNamedRaw]

    for (let i = 0; i < guards.length; i++) {
      const fallback = guardDefinitions[guards[i]] ? guardDefinitions[guards[i]].fallback : undefined
      result = await resolve(guards[i], to, fallback)
      if (!result[0]) {
        break
      }
    }

    if (result[0]) {
      next()
    } else {
      if (result[1].name === 'back') {
        next(from.path)
      } else {
        next(result[1])
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
