<script setup lang="ts">
import { ref } from 'vue'
import useAuth from '../composables/useAuth'
import SuccessAlert from './SuccessAlert.vue'
import { useRoute, RouterLink } from 'vue-router'

const { sendVerifyEmail } = useAuth()
const success = ref(false)

const route = useRoute()

async function handleResend() {
  const resp = await sendVerifyEmail()
  if (resp) {
    success.value = true
  }
}
</script>

<template>
  <div class="viewport">
    <h4>Sorry, your account is unverified.</h4>
    <p>Please check your inbox for the everification email that we sent you.</p>
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
