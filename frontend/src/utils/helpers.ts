import { watch, ref } from 'vue'
import { Router } from 'vue-router'

/**
 * This will redirect you to '/' when you are logged in and attempt to visit /register or /login
 * @param router
 * @param routeName
 * @param isLoggedIn
 * @returns
 */
export function redirectIfLoggedIn(router: Router, routeName: string | undefined | null, isLoggedIn: boolean) {
  if (!router || !routeName) return

  const isPath = ['register', 'login'].includes(routeName)

  if (isLoggedIn && isPath) {
    router.push({
      path: '/',
      replace: true,
    })
  }
}

export function useLocalStorage<T>(key: string, defaultValue: T) {
  const storedVal = localStorage.getItem(key)
  const value = ref<T>(storedVal ? JSON.parse(storedVal) : defaultValue)

  watch(
    value,
    (newValue) => {
      localStorage.setItem(key, JSON.stringify(newValue))
    },
    { deep: true },
  )

  return value
}

export function isElapsed(value: number) {
  return value < Date.now()
}
