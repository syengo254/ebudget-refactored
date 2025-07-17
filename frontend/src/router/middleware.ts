/* eslint-disable @typescript-eslint/no-unused-vars */
import { RouteLocationNamedRaw, RouteLocationNormalizedGeneric } from 'vue-router'
import { useAuthStore } from '../stores/authStore'

function auth(to: RouteLocationNormalizedGeneric): [boolean, RouteLocationNamedRaw] {
  const authStore = useAuthStore()
  return [authStore.loggedIn, { name: 'login', query: { redirect: to.fullPath } }]
}

function verified(to: RouteLocationNormalizedGeneric): [boolean, RouteLocationNamedRaw] {
  const authStore = useAuthStore()
  return [authStore.verified, { name: 'verify-account', query: { redirect: to.fullPath } }]
}

function unverified(_to: RouteLocationNormalizedGeneric): [boolean, RouteLocationNamedRaw] {
  const authStore = useAuthStore()
  return [!authStore.verified, { name: 'back' }]
}

function user(_to: RouteLocationNormalizedGeneric): [boolean, RouteLocationNamedRaw] {
  const authStore = useAuthStore()
  return [!authStore.hasStore, { name: 'dashboard' }]
}

function store(_to: RouteLocationNormalizedGeneric): [boolean, RouteLocationNamedRaw] {
  const authStore = useAuthStore()
  return [authStore.hasStore, { name: 'products' }]
}

function guest(_to: RouteLocationNormalizedGeneric): [boolean, RouteLocationNamedRaw] {
  const authStore = useAuthStore()
  return [!authStore.loggedIn, { name: 'home' }]
}

const MAP: Record<string, (to: RouteLocationNormalizedGeneric) => [boolean, RouteLocationNamedRaw]> = {
  auth,
  guest,
  verified,
  unverified,
  store,
  user,
}

export function resolve(guard: string, to: RouteLocationNormalizedGeneric) {
  if (!MAP[guard]) {
    throw new Error(`Uknown guard '${guard}' for route '${to.path}'.`)
  }

  if (import.meta.env.DEV) {
    // eslint-disable-next-line no-console
    console.log(`Authorizing guard '${guard}' for route '${to.fullPath}'`)
  }

  return MAP[guard](to)
}
