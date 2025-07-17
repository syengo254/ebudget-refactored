import { ref, reactive } from 'vue'
import { useAuthStore } from '../stores/authStore'
import { useCartStore } from '../stores/cartStore'

export default function useCheckout() {
  const useActiveAddress = ref(true)
  const selectedAddress = ref(false)
  const cashPayment = ref(true)
  const validationErrors = reactive<{ address?: string[]; payment?: string[] }>({})
  const deliveryFees = ref(350) // later this will be calculated

  const authStore = useAuthStore()
  const cartStore = useCartStore()

  const success = ref(false)
  const error = ref<boolean | Error>(false)
  const message = ref('')
  const loading = ref(false)

  async function handlePlaceOrder() {
    validationErrors.address = []
    validationErrors.payment = []

    if (!useActiveAddress.value && !selectedAddress.value) {
      validationErrors.address = ['You have to specify a delivery address.']
      return
    }
    if (!cashPayment.value) {
      validationErrors.payment = ['You have to set a payment option']
      return
    }

    loading.value = true
    const { data, errors } = await cartStore.placeOrder()
    loading.value = false

    if (errors !== null) {
      error.value = errors as Error
      message.value = error.value.message ?? 'Request failed. Please try again later.'
    } else {
      cartStore.clearCart()
      success.value = data.success
      message.value = data.message ?? 'Your order has been placed. We shall contact you for more details.'
    }
  }

  return {
    useActiveAddress,
    selectedAddress,
    cashPayment,
    validationErrors,
    deliveryFees,
    authStore,
    cartStore,
    success,
    error,
    message,
    loading,
    handlePlaceOrder,
  }
}
