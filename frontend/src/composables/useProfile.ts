import { ref } from 'vue'
import axios from '../utils/axios'
import { AddressType, UserType } from '../types'
import axiosRoot, { AxiosError } from 'axios'

export default function useProfile() {
  const apiLoading = ref(false)
  const apiSuccess = ref(false)
  const apiError = ref<Error | AxiosError | null>(null)
  const formErrors = ref<{
    phone: string[]
    city: string[]
    town: string[]
    building: string[]
    floor: string[]
    additional_info: string[]
  } | null>(null)
  const apiData = ref<{ success: boolean; user: UserType } | null>(null)

  async function addUserAddress(details: AddressType) {
    apiLoading.value = true
    try {
      await axios.get(import.meta.env.VITE_BASE_URL + 'sanctum/csrf-cookie')

      const response = await axios.post('/profiles', details)
      apiLoading.value = false

      if (response.status === 200 && response.data.success) {
        apiSuccess.value = true
        apiData.value = response.data
      }
    } catch (error) {
      apiLoading.value = false

      if (axiosRoot.isAxiosError(error)) {
        if (error.status == 422) {
          // is validation errors
          formErrors.value = error.response?.data.errors
        }
      } else {
        apiError.value = error as Error
      }
    }
  }

  return {
    addUserAddress,
    apiLoading,
    apiSuccess,
    apiError,
    apiData,
    formErrors,
  }
}
