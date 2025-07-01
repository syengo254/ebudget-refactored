import { defineStore } from 'pinia'
import { UserType } from '../types'

interface UserStoreType {
  user: UserType | null
  isLoggedIn: boolean
}

export const useUserStore = defineStore('user', {
  state: (): UserStoreType => {
    return { user: null, isLoggedIn: false }
  },
  actions: {
    setUser(user: UserType) {
      this.user = user
    },
  },
})
