<!-- eslint-disable no-console -->
<script lang="ts" setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '../../stores/authStore'
import ErrorAlert from '../../components/ErrorAlert.vue'

const email = ref('')
const password = ref('')
const loading = ref(false)
const validationErrors = ref<{
  email: string[]
  password: string[]
} | null>(null)
const loginError = ref<null | boolean | string>(null)

const router = useRouter()
const authStore = useAuthStore()

const handleLogin = async () => {
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
    router.push({
      path: '/',
      replace: true,
    })
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
        <button type="submit" class="btn btn-primary" :disabled="loading">
          {{ loading ? 'Loggin in...' : 'Login' }}
        </button>
        <ErrorAlert :show="(loginError && !validationErrors) as boolean" class="mt-1" :msg="loginError as string" />
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

button[type='submit']:hover {
  background-color: rgba(0, 0, blue, 0.6);
  color: white;
  border: 1px solid blue;
}
</style>
