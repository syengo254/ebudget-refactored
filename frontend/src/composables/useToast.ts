/* eslint-disable no-console */
import { computed, ref } from 'vue'
import { NotificationType } from '../types'

class Toast {
  message: string
  show: boolean
  lifeTime: number
  variant: NotificationType

  constructor(message: string, show: boolean, config: { variant?: NotificationType; lifeTime?: number }) {
    this.message = message
    this.show = show
    this.lifeTime = config.lifeTime ?? 4000
    this.variant = config.variant ?? 'info'
  }

  read() {
    if (import.meta.env.DEV) console.log('hidding toast...')
    new Promise<boolean>((resolve) => {
      setTimeout(() => resolve(false), this.lifeTime)
    }).then((val) => {
      this.show = val
    })
    return this.message
  }
}

const toastQueue = ref<Toast[]>([])

const TOAST_QUEUE_MAX_SIZE = 5

export default function useToast() {
  function show(content: string, config?: { variant?: NotificationType; lifeTime?: number }) {
    toastQueue.value = [...toastQueue.value.filter((toast) => toast.show)]

    if (toastQueue.value.length >= TOAST_QUEUE_MAX_SIZE) {
      return
    }

    toastQueue.value = [...toastQueue.value, new Toast(content, true, config ?? {})]
    if (import.meta.env.DEV) console.log('added toast...current length:', toastQueue.value.length)
  }

  return {
    show,
    toastQueue: computed(() => toastQueue.value.filter((toast) => toast.show)),
  }
}
