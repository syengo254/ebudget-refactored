<script setup lang="ts">
import { computed, PropType, ref } from 'vue'
import { getEstimatedDeliveryDate, getFormattedNumber } from '../../../utils/helpers'
import { ProductType } from '../../../types'
import FormSelect from '../../../components/forms/FormSelect.vue'
import BaseButton from '../../../components/buttons/BaseButton.vue'
import { RouterLink } from 'vue-router'
import { useCartStore } from '../../../stores/cartStore'

const { product } = defineProps({
  product: {
    type: Object as PropType<ProductType>,
    required: true,
  },
})
const cartStore = useCartStore()
const quantity = ref('1')
const stocked = computed(() => product.stock_amount > 0)

// handlers
const addToCart = () => {
  if (product) {
    cartStore.addItem(product, parseInt(quantity.value))
    quantity.value = '1'
  }
}
</script>

<template>
  <div id="mini-cart">
    <div class="item-price">{{ getFormattedNumber(product?.price ?? 0, 'decimal') }}/=</div>
    <div class="delivery-info">
      <p>
        <span class="block" style="margin-bottom: 0.5rem">Approx. KES 350 Delivery fee.</span>
        Delivering anywhere in Kenya. Estimated delivery date:
        <strong class="block">{{ getEstimatedDeliveryDate() }}</strong>
      </p>
    </div>
    <div class="product-stock">
      <p :class="stocked ? 'green' : 'red'">
        {{ stocked ? 'In Stock' : 'Out of Stock' }}
      </p>
    </div>
    <div class="add-cart flex gap-1">
      <FormSelect v-model="quantity" name="quantity" style="font-size: 0.95rem; border-radius: 21px">
        <template #options>
          <option v-for="num in 10" :key="num" :value="num">Quantity: {{ num }}</option>
        </template>
      </FormSelect>
      <BaseButton variant="outlined" @click="addToCart">Add To Cart</BaseButton>
    </div>
    <div class="store-info">
      <p class="text-sm">
        Available at:
        <RouterLink to="#" class="decoration-none hover-underline">{{ product.store?.name }}</RouterLink>
      </p>
    </div>
    <a href="/terms.html" class="decoration-none" style="color: rgb(30, 30, 30)"
      ><p class="muted-text">Terms and conditions apply.</p></a
    >
  </div>
</template>

<style scoped>
/* mini-cart */
div#mini-cart {
  width: 320px;
  margin-left: auto;
  border: 1px solid rgb(208, 208, 208);
  padding: 1rem;
  border-radius: 0.5rem;
}

.add-cart > button {
  display: inline-block;
  padding: 0.3rem 0.6rem;
  background: rgb(242, 126, 2);
  color: white;
  font-family: 'Roboto', sans-serif;
  cursor: pointer;
  outline: none;
  border: 1px solid rgb(242, 126, 2);
  border-radius: 21rem;
}

.add-cart > button:hover {
  background: rgb(230, 120, 2);
}

.item-price {
  font-size: 1.4rem;
  color: rgb(50, 50, 50);
  font-weight: 400;
}

@media screen and (max-width: 600px) {
  div#mini-cart {
    width: 100%;
    margin-left: 0;
    border: none;
  }
}
</style>
