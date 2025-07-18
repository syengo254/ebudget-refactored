/* eslint-disable @typescript-eslint/no-unused-vars */
import { RouteLocationNamedRaw, RouteLocationNormalizedGeneric } from 'vue-router'
import { useAuthStore } from '../stores/authStore'

async function auth(to: RouteLocationNormalizedGeneric): Promise<[boolean, RouteLocationNamedRaw]> {
  const authStore = useAuthStore()
  await authStore.checkSessionAuthenticated()

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
  return [authStore.hasStore, { name: 'home' }]
}

async function guest(_to: RouteLocationNormalizedGeneric): Promise<[boolean, RouteLocationNamedRaw]> {
  const authStore = useAuthStore()
  await authStore.checkSessionAuthenticated()
  return [authStore.loggedIn === false, authStore.hasStore ? { name: 'dashboard' } : { name: 'home' }]
}

const MAP: Record<
  string,
  (to: RouteLocationNormalizedGeneric) => [boolean, RouteLocationNamedRaw] | Promise<[boolean, RouteLocationNamedRaw]>
> = {
  auth,
  guest,
  verified,
  unverified,
  store,
  user,
}

export async function resolve(guard: string, to: RouteLocationNormalizedGeneric) {
  if (!MAP[guard]) {
    throw new Error(`Uknown guard '${guard}' for route '${to.path}'.`)
  }

  if (import.meta.env.DEV) {
    // eslint-disable-next-line no-console
    console.log(`Authorizing guard '${guard}' for route '${to.fullPath}'`)
  }

  const result = MAP[guard](to)

  return result instanceof Promise ? await result : result
}
