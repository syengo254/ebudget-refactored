<script setup lang="ts">
import { onMounted, ref } from 'vue'
import useAuth from '../composables/useAuth'
import SuccessAlert from './SuccessAlert.vue'
import { useRoute, RouterLink, useRouter } from 'vue-router'
import { useAuthStore } from '../stores/authStore'

const { sendVerifyEmail } = useAuth()
const success = ref(false)

const route = useRoute()
const router = useRouter()

async function handleResend() {
  const resp = await sendVerifyEmail()
  if (resp) {
    success.value = true
  }
}

onMounted(() => {
  const authStore = useAuthStore()
  if (authStore.verified) {
    router.push({ name: 'profile' })
  }
})
</script>

<template>
  <div class="viewport">
    <h4>Sorry, your account is unverified.</h4>
    <p>Please check your inbox for the verification email that we sent to you.</p>
    <button class="btn btn-primary" @click="handleResend">Resend verification email</button>
    <SuccessAlert :show="success" msg="Verification email sent" show-tick />
    <p>If you have verified your account, click continue.</p>
    <RouterLink :to="route.query.redirect?.toString() ?? '/'">Continue</RouterLink>
  </div>
</template>

<style scoped>
.viewport {
  text-align: center;
  max-width: 800px;
  margin: 0 auto;
  margin-top: 2rem;
}
</style>
