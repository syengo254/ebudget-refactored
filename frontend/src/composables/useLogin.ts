import { ref } from 'vue'
import axiosRoot from 'axios'
import axios from '../utils/axios.ts'
import { UserType } from '../types.ts'

export default function useLogin() {
  const loading = ref(false)
  const success = ref(false)
  const user = ref<UserType | null>(null)
  const error = ref<null | boolean | string>(null)
  const formErrors = ref<null | {
    email: string[]
    password: string[]
  }>(null)

  const resetValues = () => {
    loading.value = false
    success.value = false
    error.value = null
    formErrors.value = null
    user.value = null
  }

  async function login(credentials: { email: string; password: string }) {
    resetValues()

    try {
      let response = await axios.get(import.meta.env.VITE_BASE_URL + 'sanctum/csrf-cookie')

      if (response.status == 204) {
        // do login here

        try {
          loading.value = true
          response = await axios.post('/login', credentials)

          loading.value = false

          if (response.status == 200) {
            success.value = response.data.success
            user.value = response.data.user ?? null
            error.value = response.data.message ?? null
          }
        } catch (err) {
          loading.value = false

          if (axiosRoot.isAxiosError(err)) {
            error.value = err.response?.data.message || err.message

            if (err.response?.data.errors) {
              formErrors.value = err.response?.data.errors
            }
          }
        }
      } else {
        error.value = 'Failed to authenticate with server.'
      }
    } catch (err) {
      if (axiosRoot.isAxiosError(err)) {
        if (err.code === 'ECONNABORTED') {
          error.value = 'Could not contact the server. Check your internet connection'
        } else {
          error.value = err.message
        }
      } else {
        const _err = err as Error
        error.value = _err.message
      }
    }
  }

  return { loading, success, error, user, formErrors, login }
}
