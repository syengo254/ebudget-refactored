import axiosInstance from '../utils/axios'

import { API_URL } from '../config'
import { ProductType } from '../types'

export async function getAllProducts() {
  const url = API_URL + 'products'

  try {
    const response = await axiosInstance.get(url)
    return response.data as ProductType[]
  } catch (err) {
    // eslint-disable-next-line no-console
    console.log(err)
    return [] as ProductType[]
  }
}
