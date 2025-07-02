import { defineStore } from 'pinia'
import axiosRoot from 'axios'

import { UserType } from '../types'
import useAuth from '../composables/useAuth'
import useLogin from '../composables/useLogin'
import { ref } from 'vue'
import { isElapsed, useLocalStorage } from '../utils/helpers'
import { AUTH_CHECK_INTERVAL, LS_USER_SESSION_KEY } from '../config'

interface UserStoreType {
  user: UserType | null
  isLoggedIn: boolean
  nextAuthCheck: number
}

export const useAuthStore = defineStore('auth', {
  state: (): UserStoreType => {
    return { user: null, isLoggedIn: false, nextAuthCheck: Date.now() }
  },
  getters: {
    getUser(): UserType | null {
      return this.user
    },
    loggedIn(): boolean {
      return this.isLoggedIn
    },
  },
  actions: {
    setUser(user: UserType, isLoggedIn: boolean) {
      this.user = user
      this.isLoggedIn = isLoggedIn
      this.nextAuthCheck = Date.now() + AUTH_CHECK_INTERVAL
    },
    async checkSessionAuthenticated() {
      const localSession = useLocalStorage(LS_USER_SESSION_KEY, this.$state)
      const { checkAuth } = useAuth()

      if (isElapsed(this.nextAuthCheck) || localSession.value.isLoggedIn == false) {
        const { isLoggedIn, user, error } = await checkAuth()
        if (!error && user) {
          this.$patch({ user, isLoggedIn })
          return true
        }
        return error
      }

      this.$patch(localSession.value)
      return true
    },

    /** Login and Logout -  we shall access local storage from here*/
    async authLogin(email: string, password: string) {
      const login = useLogin()

      const success = ref(false)
      const error = ref<string | null>(null)
      const loading = ref(false)
      const formErrors = ref<{
        email: string[]
        password: string[]
      } | null>(null)

      try {
        loading.value = true
        const response = await login({ email, password })
        loading.value = false
        if (response.data.success) {
          success.value = true
          this.setUser(response.data.user, true)
        } else {
          success.value = false
          error.value = response.data.message
        }
      } catch (err) {
        loading.value = false

        if (axiosRoot.isAxiosError(err)) {
          if (err.code === 'ECONNABORTED') {
            error.value = 'Could not contact the server. Check your internet connection'
          } else if (err.response?.data.errors) {
            formErrors.value = err.response?.data.errors
          } else {
            error.value = err.response?.data.message || err.message
          }
        }
      }

      return {
        success,
        error,
        loading,
        formErrors,
      }
    },

    async authLogout() {
      const { logout } = useAuth()
      await logout()
      this.nextAuthCheck = 0
      this.$reset()
    },

    updateLocalSessionStorage() {
      return useLocalStorage(LS_USER_SESSION_KEY, this.$state)
    },
  },
})
