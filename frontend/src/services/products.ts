import axiosInstance from '../utils/axios'

import { API_URL } from '../config'
import { ProductType } from '../types'

export async function getAllProducts() {
  const url = API_URL + 'products'
  const response = await axiosInstance.get(url)
  return response.data as ProductType[]
}
