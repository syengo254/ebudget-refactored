import { UserType, UserUpdateType } from '../types.ts'
import axiosRoot, { AxiosError } from 'axios'
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
      error = err as Error
    }

    return {
      isLoggedIn: false,
      user: null,
      error: error?.message as string | null,
    }
  }

  async function patchUser(userId: number, details: UserUpdateType | FormData) {
    try {
      await axios.get(import.meta.env.VITE_BASE_URL + 'sanctum/csrf-cookie')
      const response = await axios.post(`/users/${userId}?_method=PATCH`, details, {
        headers: {
          'Content-Type': details instanceof FormData ? 'multipart/form-data' : 'application/json',
        },
      })

      return {
        data: response.data,
        isValidationError: null,
        formErrors: null,
      }
    } catch (error) {
      let formErrors = null
      if (axiosRoot.isAxiosError(error)) {
        formErrors = error.response?.data.errors ?? error
      }
      return {
        data: error as AxiosError,
        isValidationError: axiosRoot.isAxiosError(error) && error.response?.data.errors,
        formErrors,
      }
    }
  }

  return {
    logout,
    checkAuth,
    patchUser,
  }
}

export default useAuth
