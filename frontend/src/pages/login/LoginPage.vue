<!-- eslint-disable no-console -->
<script lang="ts" setup>
import { ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useAuthStore } from '../../stores/authStore'
import ErrorAlert from '../../components/ErrorAlert.vue'
import BaseButton from '../../components/buttons/BaseButton.vue'

const email = ref('')
const password = ref('')
const loading = ref(false)
const validationErrors = ref<{
  email: string[]
  password: string[]
} | null>(null)
const loginError = ref<null | string>(null)

const router = useRouter()
const route = useRoute()
const authStore = useAuthStore()

const handleLogin = async () => {
  if (loginError.value) {
    loginError.value = null
  }
  const { success, error, loading: loginLoading, formErrors } = await authStore.authLogin(email.value, password.value)

  loading.value = loginLoading.value

  if (error.value) {
    loginError.value = error.value
  }

  if (formErrors.value !== null) {
    validationErrors.value = formErrors.value
  }

  if (success.value) {
    // navigate to home
    if (route.query.redirect) {
      router.push(route.query.redirect.toString())
    } else {
      if (authStore.hasStore) {
        router.push({
          name: 'dashboard',
          replace: true,
        })
      } else {
        router.push({
          path: '/',
          replace: true,
        })
      }
    }
  }
}
</script>

<template>
  <div id="signin">
    <h4>User Login</h4>
    <form action="/login" method="post" @submit.prevent="handleLogin">
      <div class="form-group">
        <label for="user-email">Email Address</label>
        <input
          id="user-email"
          v-model="email"
          type="email"
          class="form-input"
          autocomplete="email"
          placeholder="user@example.com"
          required
        />
        <div :v-if="validationErrors !== null" class="muted-text error">
          <ul>
            <li v-for="emailErr in validationErrors?.email" :key="emailErr">{{ emailErr }}</li>
          </ul>
        </div>
      </div>

      <div class="form-group">
        <label for="user-password">Password</label>
        <input
          id="user-password"
          v-model="password"
          type="password"
          class="form-input"
          name="password"
          autocomplete="password"
          placeholder="Password"
          required
        />
        <div v-if="validationErrors !== null" class="muted-text error">
          <ul>
            <li v-for="passwdErr in validationErrors?.password" :key="passwdErr">{{ passwdErr }}</li>
          </ul>
        </div>
      </div>

      <div class="submit-btns">
        <BaseButton type="submit" variant="primary" class="mt-1" :disabled="loading">
          {{ loading ? 'Loggin in...' : 'Login' }}
        </BaseButton>
        <ErrorAlert
          :show="!!loginError && !validationErrors"
          class="mt-1"
          :msg="loginError !== null ? loginError : 'An error occured during login.'"
        />
        <div>
          <p class="mt-1">
            <RouterLink to="/reset-password">Forgot your password? Reset here</RouterLink>
          </p>
          <p class="mt-1">
            Not registered?
            <RouterLink to="/register">Click here to register.</RouterLink>
          </p>
        </div>
      </div>
    </form>
  </div>
</template>

<style scoped>
div#signin {
  position: relative;
  max-width: 360px;
  margin-inline: auto;
}
</style>
