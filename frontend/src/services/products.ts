import axiosInstance from '../utils/axios'

import { API_URL } from '../config'

export async function getAllProducts(page?: number) {
  const url = API_URL + 'products' + (page ? `?page=${page}` : '')
  const response = await axiosInstance.get(url)
  return {
    data: response.data.data,
    links: response.data.links,
    meta: response.data.meta,
  }
}
