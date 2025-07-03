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

export interface ProductType {
  id: number
  name: string
  category_id: number
  category?: {
    id: number
    name: string
  }
  store_id: number
  store?: {
    id: number
    name: string
    logo: string
  }
  price: number
  stock_amount: number
  image: string
}
