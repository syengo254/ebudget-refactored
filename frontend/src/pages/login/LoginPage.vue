<!-- eslint-disable no-console -->
<script lang="ts" setup>
import { ref } from 'vue'
import useLogin from '../../composables/useLogin'
import { useRouter } from 'vue-router'
import { useUserStore } from '../../stores/useUserStore'
import { UserType } from '../../types'

const email = ref('')
const password = ref('')

const router = useRouter()
const userStore = useUserStore()

const { user, success, error, loading, login, formErrors } = useLogin()

const handleLogin = async () => {
  await login({ email: email.value, password: password.value })

  if (success.value) {
    // add user to pinia store
    userStore.setUser(user.value as UserType)

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
        <div :v-if="formErrors !== null" class="muted-text error">
          <ul>
            <li v-for="emailErr in formErrors?.email" :key="emailErr">{{ emailErr }}</li>
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
        <div v-if="formErrors !== null" class="muted-text error">
          <ul>
            <li v-for="passwdErr in formErrors?.password" :key="passwdErr">{{ passwdErr }}</li>
          </ul>
        </div>
      </div>

      <div class="submit-btns">
        <button type="submit" class="btn btn-primary">{{ loading ? 'Loggin in...' : 'Login' }}</button>
        <p style="margin: 0.5rem 0">
          Not registered? Click here to
          <RouterLink to="/register">Register.</RouterLink>
        </p>
      </div>

      <div v-show="error && !formErrors" class="alert error mt-1 block semibold">
        <p>{{ error }}</p>
      </div>
    </form>
  </div>
</template>

<style scoped>
div#signin {
  position: relative;
  max-width: 320px;
  margin-inline: auto;
}

button[type='submit']:hover {
  background-color: rgba(0, 0, blue, 0.6);
  color: white;
  border: 1px solid blue;
}
</style>
