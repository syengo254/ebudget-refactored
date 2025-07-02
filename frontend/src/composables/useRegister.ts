import { ref } from 'vue'
import axiosRoot from 'axios'
import axios from '../utils/axios.ts'
import { UserRegistrationType, UserType } from '../types.ts'

export default function useRegister() {
  const loading = ref(false)
  const success = ref(false)
  const user = ref<UserType | null>(null)
  const error = ref<null | boolean | string>(null)
  const formErrors = ref<null | {
    name: string[]
    email: string[]
    password: string[]
    password_confirmation: string[]
    has_store: string
  }>(null)

  const resetValues = () => {
    loading.value = false
    success.value = false
    error.value = null
    formErrors.value = null
    user.value = null
  }

  async function register(userInfo: UserRegistrationType) {
    resetValues()

    try {
      let response = await axios.get(import.meta.env.VITE_BASE_URL + 'sanctum/csrf-cookie')

      if (response.status == 204) {
        // do login here

        try {
          loading.value = true

          userInfo.has_store = userInfo.has_store || false
          response = await axios.post('/users', userInfo)

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
        error.value = 'Failed to contact the server.'
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

  return { loading, success, error, user, formErrors, register }
}
