import { mount } from '@vue/test-utils'
import ToastMessageNotification from '../components/ToastMessageNotification.vue'
import { computed } from 'vue'
import { Toast } from '../utils/classes'

const toastString = 'A simple toast notification'

vi.mock('../composables/useToast', () => ({
  default: () => ({
    toastQueue: computed(() => [new Toast(toastString, true, {})]),
  }),
}))

test('that a toastnotification is shown', () => {
  // Arrange & Act
  mount(ToastMessageNotification, { props: { position: 'center' } })

  // assert
  expect(document.body.innerHTML).toContain('toast-group center')
  expect(document.body.innerHTML).toContain('transition-group')
  expect(document.body.querySelectorAll('div.toast')).toHaveLength(1)
  expect(document.body.querySelectorAll('div.toast')[0].innerHTML).toEqual(toastString)
})
