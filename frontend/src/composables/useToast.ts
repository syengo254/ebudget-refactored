/* eslint-disable no-console */
import { computed, ref } from 'vue'
import { NotificationType } from '../types'
import { Toast } from '../utils/classes'

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
