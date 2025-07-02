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
