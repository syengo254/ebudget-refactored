import { UserType } from '../types.ts'
import axios from '../utils/axios.ts'

function useAuth() {
  async function logout() {
    const response = await axios.post('/logout')

    if (response.status == 200) {
      return response.data.success
    }
    return false
  }

  async function checkAuth() {
    let error: Error | null = null

    try {
      // eslint-disable-next-line no-console
      console.log('checking auth...')
      await axios.get(import.meta.env.VITE_BASE_URL + 'sanctum/csrf-cookie')

      const response = await axios.get('/authenticated')

      if (response.status == 200) {
        return {
          isLoggedIn: response.data.authenticated as boolean,
          user: response.data.user as UserType | null,
          error: null as string | null,
        }
      }
    } catch (err) {
      // eslint-disable-next-line no-console
      console.error(err)

      error = err as Error
    }

    return {
      isLoggedIn: false,
      user: null,
      error: error?.message as string | null,
    }
  }

  return {
    logout,
    checkAuth,
  }
}

export default useAuth
