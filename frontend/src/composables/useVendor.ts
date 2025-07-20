import axios from '../utils/axios'

export default function useVendor(vendorId: number) {
  async function getVendorOrders() {
    try {
      const response = await axios.get(`/stores/${vendorId}/orders`)
      return response.data
    } catch (error) {
      return error
    }
  }

  return {
    getVendorOrders,
  }
}
