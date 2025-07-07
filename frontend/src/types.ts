export type UserType = {
  id: number
  name: string
  email: string
  hasStore: boolean
}

export type UserRegistrationType = {
  email: string
  password: string
  password_confirmation: string
  has_store?: boolean
  name: string
}

export type CategoryType = {
  id: number
  name: string
}
export type StoreType = {
  id: number
  name: string
  logo: string
}
export interface ProductType {
  id: number
  name: string
  category_id: number
  category?: CategoryType
  store_id: number
  store?: StoreType
  price: number
  stock_amount: number
  image: string
}
