<script setup lang="ts">
import { ref } from 'vue'
import Error from '../../components/forms/Error.vue'
import FormInput from '../../components/forms/FormInput.vue'
import SuccessAlert from '../../components/SuccessAlert.vue'
import SubmitButton from '../profile/components/SubmitButton.vue'
import { RouterLink } from 'vue-router'

const email = ref('')
const success = ref(false)
const loading = ref(false)
const successMessage = ref(
  `We have sent a password reset link to the email address '${email.value}'.
   Check your email inbox and click on the link sent to reset your password.`,
)

function sendLink() {
  // todo
}

// handlers
function handleSubmit() {
  success.value = !success.value
}

function resendLink() {
  if (email.value.length > 4) sendLink()
}
</script>

<template>
  <section class="main">
    <h3>Reset your password</h3>
    <p v-show="!success" class="help">
      Enter your email address and click on the 'Reset Password' button. An email with a password-reset-link to be sent
      to you.
    </p>

    <div v-if="!success" class="reset-form">
      <form action="/reset-password" method="post" @submit.prevent="handleSubmit">
        <div class="form-group">
          <FormInput
            name="email"
            label="Enter your email address"
            type="email"
            placeholder="user@example.com"
            :required="true"
            :style="'text-align: center;'"
          >
            <Error :form-errors="[]" />
          </FormInput>
        </div>
        <div class="submit-btns">
          <SubmitButton v-if="true" type="submit" :disabled="loading">
            {{ false ? 'Sending...' : 'Reset Password' }}
          </SubmitButton>
        </div>
      </form>
    </div>
    <div v-else class="alert-section">
      <SuccessAlert :show="success" :msg="successMessage" />
      <div class="submit-btns mt-1">
        <SubmitButton type="submit" :disabled="false" @click="resendLink">
          {{ false ? 'Sending...' : 'Resend Link' }}
        </SubmitButton>
        <p class="help" style="font-style: italic">
          If you don't receive any email within <strong>10-15</strong> minutes, you have not registered with us. Click
          <RouterLink to="/register"> here </RouterLink> to register.
        </p>
      </div>
    </div>
  </section>
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
