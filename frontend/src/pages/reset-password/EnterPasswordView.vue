<script setup lang="ts">
import { reactive, ref } from 'vue'
import axiosRoot from 'axios'
import axios from '../../utils/axios'
import FormInput from '../../components/forms/FormInput.vue'
import Error from '../../components/forms/Error.vue'
import SubmitButton from '../profile/components/SubmitButton.vue'
import SuccessAlert from '../../components/SuccessAlert.vue'
import ErrorAlert from '../../components/ErrorAlert.vue'

const props = defineProps({
  token: {
    type: String,
    required: true,
  },
  email: {
    type: String,
    required: true,
  },
})

const passwords = reactive({
  password: '',
  password_confirmation: '',
})

const validationErrors = reactive<{ password: string[] | null }>({
  password: null,
})

const showResetLink = ref(false)
const loading = ref(false)
const success = ref(false)
const error = ref(false)
const successMessage = 'Your password has been changed. Proceed to login'

async function handleSubmit() {
  if (passwords.password !== passwords.password_confirmation) {
    validationErrors.password = ['Password do not match.']
    return
  }
  if (passwords.password.length < 8) {
    validationErrors.password = ['Password shoud be atleast 8 characters long.']
    return
  }

  validationErrors.password = []
  error.value = false

  try {
    loading.value = true
    await axios.get(import.meta.env.VITE_BASE_URL + 'sanctum/csrf-cookie')
    const response = await axios.post('/reset-password/' + props.token, {
      token: props.token,
      email: props.email,
      ...passwords,
    })

    if (response.status === 200) {
      if (response.data.success == true) {
        success.value = true
      } else {
        error.value = true
        if (response.data.status && response.data.status == 'passwords.token') {
          validationErrors.password = ['This password reset link has expired. Reset again']
          showResetLink.value = true
        } else {
          validationErrors.password = [
            'Failed to update your password, please contact support: ' + import.meta.env.VITE_APP_DOMAIN,
          ]
        }
      }
    }
  } catch (err) {
    error.value = true
    if (axiosRoot.isAxiosError(err) && err.response?.data.errors) {
      validationErrors.password = err.response?.data.errors
    } else {
      validationErrors.password = [(err as Error).message]
    }
  } finally {
    loading.value = false
  }
}
</script>
//
<template>
  <div id="change-password">
    <h3>Reset your password</h3>
    <p v-show="!success" class="help">Enter your new password to continue.</p>
    <form v-if="!success" action="" method="post" @submit.prevent="handleSubmit">
      <div class="form-group">
        <FormInput
          v-model="passwords.password"
          type="password"
          name="password"
          label="Password"
          autocomplete="password"
          placeholder="Password"
          :style="'text-align: center'"
          required
        />
        <Error v-if="!error" :form-errors="validationErrors?.password ?? undefined" />
      </div>
      <div class="form-group">
        <FormInput
          v-model="passwords.password_confirmation"
          type="password"
          name="password2"
          label="Confirm Password"
          autocomplete="password"
          placeholder="Password"
          :style="'text-align: center'"
          required
        />
      </div>
      <div class="submit-btns">
        <SubmitButton type="submit" :disabled="loading">
          {{ loading ? 'Saving...' : 'Change Password' }}
        </SubmitButton>
      </div>
    </form>
    <div class="alert-section">
      <SuccessAlert :show="success" :msg="successMessage" />
      <ErrorAlert :show="error" :msg="validationErrors?.password ? validationErrors?.password[0] : ''" />
      <a v-if="showResetLink" href="/reset-password?fresh=fresh" class="mt-1">Reset Password</a>
    </div>
  </div>
</template>

<style scoped>
#change-password {
  text-align: center;
  width: min(400px, 100%);
  margin-inline: auto;
}

.help {
  max-width: 500px;
  text-align: center;
  margin-inline: auto;
  font-size: 0.9rem;
  font-style: italic;
}

div.submit-btns {
  display: flex;
  flex-direction: row;
  flex-wrap: wrap;
  justify-content: center;
  margin-top: 1rem;
}

button.btn-cancel:hover {
  background-color: rgb(228, 228, 228);
}
</style>
