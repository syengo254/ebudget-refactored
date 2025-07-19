import { defineStore } from 'pinia'
import { v4 as uuidv4 } from 'uuid'
import { CartItemsType, ProductType, ShoppingCartType } from '../types'
import { useLocalStorage } from '../utils/helpers'
import { LS_CART_KEY } from '../config'
import { OrderService } from '../services/order'

const emptyCart: ShoppingCartType = {
  cart_id: uuidv4(),
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
    isInCart(state) {
      return (productId: number) => Boolean(state.items[productId])
    },
  },
  actions: {
    setUserId(userId: number) {
      this.$state.userId = userId
    },
    addItem(item: ProductType, quantity: number = 1) {
      if (this.items[item.id]) {
        if (this.items[item.id].count == 10) return
        this.items[item.id].count += quantity
      } else {
        this.items[item.id] = {
          product: item,
          count: quantity,
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
      this.cart_id = uuidv4()
      this.items = {}
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

    async placeOrder() {
      const { data, errors } = await OrderService.make(this.$state)

      return {
        data,
        errors,
      }
    },
  },
})
