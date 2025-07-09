import axiosInstance from '../utils/axios'

import { API_URL } from '../config'
import { ProductsFiltersType } from '../types'

async function productsFetch(url: string) {
  const response = await axiosInstance.get(url)
  return {
    data: response.data.data,
    links: response.data.links,
    meta: response.data.meta,
  }
}

export async function getProducts(page?: number, filters?: ProductsFiltersType) {
  let url = API_URL + 'products' + (page ? `?page=${page}` : '')

  if (filters) {
    const filterKeys = Object.keys(filters)

    if (filterKeys.length > 0) {
      filterKeys.forEach((key) => {
        url += `&${key}=${filters[key]}`
      })
    }
  }

  return await productsFetch(url)
}
