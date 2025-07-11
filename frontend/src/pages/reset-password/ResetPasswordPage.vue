<script setup lang="ts">
import { computed, onMounted, ref } from 'vue'
import axiosRoot from 'axios'
import axios from '../../utils/axios'
import Error from '../../components/forms/Error.vue'
import FormInput from '../../components/forms/FormInput.vue'
import SuccessAlert from '../../components/SuccessAlert.vue'
import SubmitButton from '../profile/components/SubmitButton.vue'
import { RouterLink, useRoute } from 'vue-router'
import ErrorAlert from '../../components/ErrorAlert.vue'
import EnterPasswordView from './EnterPasswordView.vue'

const route = useRoute()
const pageReady = ref(false)
const stepTwo = ref(false)
const token = ref('')
const email = ref('')

onMounted(() => {
  if (route.query.token && route.query.email) {
    token.value = route.query.token.toString()
    email.value = route.query.email.toString()
    stepTwo.value = true
  }
  pageReady.value = true
})

const success = ref(false)
const error = ref(false)
const validationErrors = ref<{ email: string[] } | null>(null)
const loading = ref(false)

const successMessage = computed(
  () =>
    `We have sent a password reset link to the email address '${email.value}'.
   Check your email inbox and click on the link sent to reset your password.`,
)

async function sendLink(data: { email: string }) {
  try {
    loading.value = true
    await axios.get(import.meta.env.VITE_BASE_URL + 'sanctum/csrf-cookie')
    const response = await axios.post('/forgot-password', data)

    if (response.status === 200) {
      if (response.data.success == true) {
        success.value = true
        email.value = data.email
      } else {
        error.value = true
        if (response.data.status && response.data.status == 'passwords.user') {
          validationErrors.value = { email: ['This email address is not in our records. Please register.'] }
        } else {
          validationErrors.value = { email: ['Failed to send reset email, please try again later.'] }
        }
      }
    }
  } catch (err) {
    error.value = true
    if (axiosRoot.isAxiosError(err) && err.response?.data.errors) {
      validationErrors.value = err.response?.data.errors
    } else {
      validationErrors.value = { email: [(err as Error).message] }
    }
  } finally {
    loading.value = false
  }
}

// handlers
async function handleSubmit() {
  if (email.value.length < 6) {
    validationErrors.value = { email: ['Email should be atleast 6 charaxters long'] }
    return
  } else {
    validationErrors.value = null
    error.value = false
    await sendLink({ email: email.value })
  }
}

async function resendLink() {
  if (email.value.length > 6) {
    success.value = false
    validationErrors.value = null
    error.value = false
    await sendLink({ email: email.value })
  }
}
</script>

<template>
  <main v-if="pageReady">
    <section v-if="stepTwo" class="main">
      <EnterPasswordView :token="token" :email="email" />
    </section>
    <section v-else class="main">
      <h3>Reset your password</h3>
      <p v-show="!success" class="help">
        Enter your email address and click on the 'Reset Password' button. An email with a password-reset-link to be
        sent to you.
      </p>
      <div v-if="!success" class="reset-form">
        <form action="/reset-password" method="post" @submit.prevent="handleSubmit">
          <div class="form-group">
            <FormInput
              v-model="email"
              name="email"
              label="Enter your email address"
              type="email"
              placeholder="user@example.com"
              :required="true"
              :style="'text-align: center;'"
            >
              <Error :form-errors="validationErrors?.email" />
            </FormInput>
          </div>
          <div class="submit-btns">
            <SubmitButton type="submit" :disabled="loading">
              {{ loading ? 'Sending...' : 'Reset Password' }}
            </SubmitButton>
          </div>
        </form>
      </div>
      <div v-else class="alert-section">
        <SuccessAlert :show="success" :msg="successMessage" />
        <ErrorAlert :show="error" :msg="validationErrors?.email[0] ?? ''" />
        <div class="submit-btns mt-1">
          <SubmitButton type="submit" :disabled="loading" @click="resendLink">
            {{ loading ? 'Sending...' : 'Resend Link' }}
          </SubmitButton>
          <p class="help" style="font-style: italic">
            If you don't receive any email within <strong>10-15</strong> minutes, you have not registered with us. Click
            <RouterLink to="/register"> here to register.</RouterLink>
          </p>
        </div>
      </div>
    </section>
  </main>
</template>

<style scoped>
h3 {
  text-align: center;
  margin-top: 3rem;
}

section.main {
  padding: 1rem;
}

.help {
  max-width: 500px;
  text-align: center;
  margin-inline: auto;
  font-size: 0.9rem;
}

.reset-form {
  max-width: 400px;
  margin-inline: auto;
  margin-top: 2rem;
}

.alert-section {
  max-width: 450px;
  margin: 2rem auto;
}

div.submit-btns {
  display: flex;
  flex-direction: row;
  flex-wrap: wrap;
  justify-content: center;
}

button.btn-cancel:hover {
  background-color: rgb(228, 228, 228);
}
</style>
