/* eslint-disable @typescript-eslint/no-unused-vars */
import { RouteLocationNamedRaw, RouteLocationNormalizedGeneric } from 'vue-router'
import { useAuthStore } from '../stores/authStore'

async function auth(to?: RouteLocationNormalizedGeneric, fallback?: string): Promise<[boolean, RouteLocationNamedRaw]> {
  const authStore = useAuthStore()
  await authStore.checkSessionAuthenticated()

  return [authStore.loggedIn, { name: fallback ?? 'login', query: { redirect: to?.fullPath } }]
}

async function verified(to?: RouteLocationNormalizedGeneric): Promise<[boolean, RouteLocationNamedRaw]> {
  const authStore = useAuthStore()
  await authStore.checkSessionAuthenticated(true)
  return [authStore.verified, { name: 'verify-account', query: { redirect: to?.fullPath } }]
}

function unverified(): [boolean, RouteLocationNamedRaw] {
  const authStore = useAuthStore()
  return [!authStore.verified, { name: 'back' }]
}

function user(): [boolean, RouteLocationNamedRaw] {
  const authStore = useAuthStore()
  return [!authStore.hasStore, { name: 'dashboard' }]
}

function store(): [boolean, RouteLocationNamedRaw] {
  const authStore = useAuthStore()
  return [authStore.hasStore, { name: 'home' }]
}

async function guest(): Promise<[boolean, RouteLocationNamedRaw]> {
  const authStore = useAuthStore()
  await authStore.checkSessionAuthenticated()
  return [authStore.loggedIn === false, authStore.hasStore ? { name: 'dashboard' } : { name: 'home' }]
}

const MAP: Record<
  string,
  (
    to?: RouteLocationNormalizedGeneric,
    fallback?: string,
  ) => [boolean, RouteLocationNamedRaw] | Promise<[boolean, RouteLocationNamedRaw]>
> = {
  auth,
  guest,
  verified,
  unverified,
  store,
  user,
}

export async function resolve(guard: string, to: RouteLocationNormalizedGeneric, fallback?: string) {
  if (!MAP[guard]) {
    throw new Error(`Uknown guard '${guard}' for route '${to.path}'.`)
  }

  if (import.meta.env.DEV) {
    // eslint-disable-next-line no-console
    console.log(`Authorizing guard '${guard}' for route '${to.fullPath}'`)
  }

  const result = MAP[guard](to, fallback)

  return result instanceof Promise ? await result : result
}
