<script setup lang="ts">
import { RouterLink, useRouter } from 'vue-router'
import cartLogoWhite from '@/assets/ebudget_shopping_cart_icon_white.png'
import { useCartStore } from '../../stores/cartStore'
import { onMounted } from 'vue'
const router = useRouter()
const cartStore = useCartStore()

function handleCartClick() {
  router.push({
    name: 'shopping-cart',
  })
}

onMounted(() => {
  // read shopping cart from LS
  cartStore.setStateFromLS()
})
</script>
<template>
  <div class="shopping-cart-container" @click="handleCartClick">
    <div style="position: relative">
      <div class="shopping-cart-icon">
        <img :src="cartLogoWhite" alt="shopping-cart-icon" />
      </div>
      <div class="cart-counter">
        <span>{{ cartStore.count }}</span>
      </div>
    </div>
    <div v-show="cartStore.count">
      <RouterLink to="/shopping-cart" class="text-white cart-link text-md">Checkout</RouterLink>
    </div>
  </div>
</template>

<style scoped>
div.shopping-cart-container {
  position: relative;
  display: flex;
  flex-direction: row;
  flex-wrap: wrap;
  gap: 0.5rem;
  margin-left: auto;
  margin-right: 2.5rem;
  cursor: pointer;
  align-items: center;
}

div.shopping-cart-icon {
  position: relative;
  width: 42px;
  height: 42px;
}

div.shopping-cart-icon > img {
  position: relative;
  width: 42px;
  height: 42px;
}
.cart-counter {
  position: absolute;
  display: flex;
  align-items: center;
  flex-direction: row;
  justify-content: center;
  z-index: 10;
  top: -0.25rem;
  left: calc(50% - 0.4rem);
  color: white;
  background: rgb(228, 85, 3);
  text-align: center;
  font-size: 0.9rem;
  min-width: 1.4rem;
  min-height: 1.4rem;
  padding: 0.25rem;
  border-radius: 50%;
  font-weight: 500;
}
.cart-link {
  text-decoration: none;
}

.cart-link:hover {
  text-decoration: underline;
}
</style>
