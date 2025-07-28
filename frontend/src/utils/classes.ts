/* eslint-disable no-console */
import { NotificationType } from '../types'

export class Toast {
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
