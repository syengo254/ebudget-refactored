import { defineStore } from 'pinia'
import { ProductType, ShoppingCartType } from '../types'
import { useLocalStorage } from '../utils/helpers'
import { LS_CART_KEY } from '../config'

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
  },
  actions: {
    addItem(item: ProductType) {
      if (this.items[item.id]) {
        this.items[item.id].count++
      } else {
        this.items[item.id] = {
          product: item,
          count: 1,
        }
      }
      this.updateLocalStorage()
    },
    removeItems(itemId: number, clear = false) {
      if (clear) {
        delete this.items[itemId]
      } else {
        this.items[itemId].count--
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
      const ls = this.readLocalStrorage()
      this.$patch(ls.value)
    },
    /**
     * TODO: place order
     */
  },
})
