import { defineStore } from 'pinia'
import { CartItemsType, ProductType, ShoppingCartType } from '../types'
import { useLocalStorage } from '../utils/helpers'
import { LS_CART_KEY } from '../config'
import { useAuthStore } from './authStore'

const emptyCart: ShoppingCartType = {
  items: {},
  maxSize: 50,
}
export const useCartStore = defineStore('shopping-cart', {
  state: (): ShoppingCartType => emptyCart,
  getters: {
    count(state) {
      return Object.keys(state.items).reduce((prev, currKey) => {
        return prev + state.items[currKey].count
      }, 0)
    },
    distinctCount(state) {
      return Object.keys(state.items).length
    },
    hasItems(state) {
      return Object.keys(state.items).length > 0
    },
    productInCart(state) {
      return (productId: number | string) => Boolean(state.items[productId])
    },
    subtotal(state) {
      return Object.keys(state.items).reduce((prev, currKey) => {
        return prev + (state.items[currKey].product.price ?? 0) * state.items[currKey].count
      }, 0)
    },
    getItemsIds(state) {
      return Object.keys(state.items)
    },
    getItemById(state) {
      return (itemId: keyof CartItemsType) => state.items[itemId]
    },
  },
  actions: {
    addItem(item: ProductType) {
      if (this.items[item.id]) {
        if (this.items[item.id].count == 10) return
        this.items[item.id].count++
      } else {
        this.items[item.id] = {
          product: item,
          count: 1,
        }
      }
      this.updateLocalStorage()
    },
    removeItem(itemId: keyof CartItemsType, clear = false) {
      this.items[itemId].count--

      if (clear || this.items[itemId].count < 1) {
        delete this.items[itemId]
      }

      this.updateLocalStorage()
    },
    clearCart() {
      this.$patch(emptyCart)
      this.updateLocalStorage()
    },
    updateLocalStorage() {
      const cartLS = this.readLocalStrorage()
      cartLS.value = this.$state
    },
    readLocalStrorage() {
      return useLocalStorage(LS_CART_KEY, emptyCart)
    },
    setStateFromLS() {
      const authStore = useAuthStore()
      const ls = this.readLocalStrorage()

      if (ls.value.userId && authStore.isLoggedIn) {
        if (ls.value.userId !== authStore.user?.id) {
          ls.value = emptyCart
        }
      }

      this.$patch(ls.value)
    },
    /**
     * TODO: place order
     */
  },
})
