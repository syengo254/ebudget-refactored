<script setup lang="ts">
import Error from '@/components/forms/Error.vue'
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/authStore'
import useRegister from '@/composables/useRegister'

const name = ref('')
const email = ref('')
const password = ref('')
const password_confirmation = ref('')

const router = useRouter()
const authStore = useAuthStore()

// eslint-disable-next-line vue/require-prop-types
const props = defineProps(['formTitle'])

const { user, success, error, loading, register, formErrors } = useRegister()

const handleRegister = async () => {
  await register({
    name: name.value,
    email: email.value,
    password: password.value,
    password_confirmation: password_confirmation.value,
    has_store: props.formTitle == 'Vendor',
  })

  if (success.value) {
    // add user to pinia store
    authStore.setUser(user.value, true)

    // navigate to home
    router.push({
      path: '/',
      replace: true,
    })
  }
}
</script>

<template>
  <div class="customer-signup">
    <h5>{{ props.formTitle }} Sign Up</h5>
    <span class="info-text text-center">Sign up here if you are a {{ props.formTitle }}.</span>
    <form action="/register" method="post" @submit.prevent="handleRegister">
      <div class="form-group">
        <label :for="`fullname-${props.formTitle}`">{{ props.formTitle }} Name</label>
        <input
          :id="`fullname-${props.formTitle}`"
          v-model="name"
          type="text"
          class="form-input"
          name="name"
          :placeholder="props.formTitle == 'Vendor' ? 'Your company name' : 'Your name'"
          required
        />
        <Error v-if="formErrors" :form-errors="formErrors?.name" />
      </div>

      <div class="form-group">
        <label :for="'email-' + formTitle">Email Address</label>
        <input
          :id="'email-' + formTitle"
          v-model="email"
          type="email"
          class="form-input"
          placeholder="user@example.com"
          autocomplete="email"
          required
        />
        <Error v-if="formErrors" :form-errors="formErrors?.email" />
      </div>

      <div class="form-group">
        <label :for="'customer-password1' + formTitle">Password</label>
        <input
          :id="'customer-password1' + formTitle"
          v-model="password"
          type="password"
          class="form-input"
          autocomplete="new-password"
          placeholder="Password"
          required
        />
        <Error v-if="formErrors" :form-errors="formErrors?.password" />
      </div>

      <div class="form-group">
        <label :for="'customer-password2' + formTitle">Confirm password</label>
        <input
          :id="'customer-password2' + formTitle"
          v-model="password_confirmation"
          type="password"
          class="form-input"
          autocomplete="new-password"
          placeholder="Password"
          required
        />
        <Error v-if="formErrors" :form-errors="formErrors?.password_confirmation" />
      </div>

      <div class="submit-btns">
        <button type="submit" class="btn block" :disabled="loading">Register</button>
        <p style="margin: 0.5rem 0">Already registered? Click here to <RouterLink to="/login">Sign in.</RouterLink></p>
      </div>

      <div v-show="error" class="alert error mt-1 block">
        <p>
          <!-- Messages here -->
          {{ error }}
        </p>
      </div>
    </form>
  </div>
</template>

<style scoped>
div.customer-signup {
  position: relative;
  width: 400px;
  border: 1px solid rgb(180, 180, 180);
  padding: 1rem;
  margin: 1rem;
  border-radius: 3.5px;
}

div.customer-signup > h5 {
  margin: 0.5rem 0;
  text-align: center;
  font-size: 1.4rem;
  font-weight: 500;
  color: rgba(0, 0, 0, 0.85);
}

div.submit-btns {
  display: flex;
  flex-direction: column;
  margin-top: 1rem;
}

div.submit-btns button[type='submit'] {
  background-color: blue;
  color: white;
  border: 1px solid blue;
  cursor: pointer;
  font-weight: 600;
}

div.submit-btns button[type='submit']:hover {
  background-color: rgb(2, 2, 173);
}

label {
  color: rgba(0, 0, 0, 0.85);
  margin-top: 0.5rem;
  font-size: 0.9rem;
}
</style>
