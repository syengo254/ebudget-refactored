export type UserType = {
  id: number
  name: string
  email: string
  hasStore: boolean
  store?: StoreType
  address?: AddressType
  profile?: ProfileType
}

export type ProfileType = {
  id?: number
  phone?: string
  active_address_id?: number
}

export type AddressType = {
  phone?: string
  city?: string
  town?: string
  building?: string
  floor?: string
  additional_info?: string
}

export type UserRegistrationType = {
  email: string
  password: string
  password_confirmation: string
  has_store?: boolean
  name: string
}

export type UserUpdateType = {
  [Property in keyof Omit<UserRegistrationType, 'has_store' | 'email'>]?: UserRegistrationType[Property]
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

export type ProductsFiltersType = {
  category?: string
  price?: number
  store?: string
}
