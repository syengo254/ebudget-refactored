import axios from '../utils/axios'
import { CartItemsType, ShoppingCartType } from '../types'
import { isAxiosError } from 'axios'

export class OrderService {
  static async make(orderData: ShoppingCartType) {
    let errors = null
    let respData = null

    try {
      await axios.get(import.meta.env.VITE_BASE_URL + 'sanctum/csrf-cookie')

      const data = Object.keys(orderData.items).map((key: keyof CartItemsType) => {
        return { product_id: orderData.items[key].product.id, count: orderData.items[key].count }
      })

      const response = await axios.post('/orders', { order: data, cart_id: orderData.cart_id })
      if (response.status == 200) {
        respData = response.data

        if (!response.data.success) throw new Error(response.data.message)
      }
    } catch (err) {
      if (isAxiosError(err) && err?.response?.data.message) {
        errors = new Error(err?.response?.data.message)
      } else {
        errors = err
      }
    }

    return {
      errors,
      data: respData,
    }
  }
}
