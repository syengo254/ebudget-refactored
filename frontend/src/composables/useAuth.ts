import axios from '../utils/axios.ts'

function useAuth() {
  async function logout() {
    const response = await axios.post('/logout')

    if (response.status == 200) {
      return response.data.success
    }
  }

  async function checkAuth() {
    let error = null

    try {
      console.log('checking auth...')
      await axios.get(import.meta.env.VITE_BASE_URL + 'sanctum/csrf-cookie')

      const response = await axios.get('/authenticated')

      if (response.status == 200) {
        return {
          isLoggedIn: response.data.authenticated,
          user: response.data.user,
          error: null,
        }
      }
    } catch (err) {
      // eslint-disable-next-line no-console
      console.error(err)

      error = err as Error
    }

    return {
      isLogged: false,
      user: null,
      error: error?.message,
    }
  }

  return {
    logout,
    checkAuth,
  }
}

export default useAuth
