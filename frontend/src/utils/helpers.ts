import { AxiosResponse } from 'axios'
import { watch, ref } from 'vue'

export function useLocalStorage<T>(key: string, defaultValue: T) {
  const storedVal = localStorage.getItem(key)
  const value = ref<T>(storedVal ? JSON.parse(storedVal) : defaultValue)

  watch(
    value,
    (newValue) => {
      localStorage.setItem(key, JSON.stringify(newValue))
    },
    { deep: true },
  )

  return value
}

export function isElapsed(value: number) {
  return value < Date.now()
}

export function getFormattedNumber(num: number, style: 'currency' | 'decimal' = 'currency'): string {
  return Intl.NumberFormat('en-GB', {
    style,
    ...(style == 'decimal' ? { minimumFractionDigits: 2, maximumFractionDigits: 2 } : { currency: 'KES' }),
  }).format(num)
}

export const getRandomNumber = (max: number = 1000) => Math.floor(Math.random() * max)

export function formatString(str: string, ...values: string[]) {
  return str.replace(/{(\d+)}/g, function (match, index) {
    return typeof values[index] !== 'undefined' ? values[index] : match
  })
}

export const getEstimatedDeliveryDate = () => {
  return new Date(new Date().setDate(new Date().getDate() + getRandomNumber(3))).toDateString()
}

export const getDateFromString = (input: string) => {
  return new Date(input).toDateString()
}

export const generatePaginationData = (response: AxiosResponse) => {
  return {
    total: response.data.total,
    current_page: response.data.current_page,
    from: response.data.from,
    last_page: response.data.last_page,
    links: response.data.links,
    path: response.data.path,
    per_page: response.data.per_page,
    to: response.data.to,
  }
}
