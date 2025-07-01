import { Router } from 'vue-router'

export default function useRedirectIfLoggedIn(
  router: Router,
  routeName: string | undefined | null,
  isLoggedIn: boolean,
) {
  if (!router || !routeName) return

  const isPath = ['register', 'login'].includes(routeName)

  if (isLoggedIn && isPath) {
    router.push({
      path: '/',
      replace: true,
    })
  }
}
