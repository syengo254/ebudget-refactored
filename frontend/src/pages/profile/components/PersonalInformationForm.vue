<script lang="ts" setup>
import { ref } from 'vue'
import Error from '../../../components/forms/Error.vue'
import FormInput from '../../../components/forms/FormInput.vue'
import SubmitButton from './SubmitButton.vue'
import ErrorAlert from '../../../components/ErrorAlert.vue'
import { useAuthStore } from '../../../stores/authStore'

const authStore = useAuthStore()

const name = ref(authStore.user?.name)
const email = ref(authStore.user?.email)
const logo = ref(authStore.user?.store?.logo)
const password = ref('')
const password_confirmation = ref('')
const loading = ref(false)

const personalDisabled = ref(true)

const updateError = ref<null | boolean | string>(null)

const validationErrors = ref<{
  email: string[]
  password: string[]
  password_confirmation: string[]
  name: string[]
  logo?: string[]
} | null>(null)

function togglePersonalForm() {
  personalDisabled.value = !personalDisabled.value
}
</script>

<template>
  <form action="/profile" method="post" autocomplete="off">
    <fieldset>
      <legend><h4>Personal Information</h4></legend>
      <div class="form-group">
        <FormInput
          v-model="name"
          type="text"
          name="name"
          label="Your name"
          :disabled="personalDisabled"
          :required="true"
        >
          <Error :form-errors="validationErrors?.name" />
        </FormInput>
      </div>
      <div class="form-group">
        <FormInput
          v-model="email"
          type="email"
          name="email"
          label="Email address"
          placeholder="email@example.com"
          :disabled="personalDisabled"
          :required="true"
        >
          <Error :form-errors="validationErrors?.email" />
        </FormInput>
      </div>
      <div v-show="authStore.user?.hasStore" class="form-group">
        <FormInput
          v-model="logo"
          type="file"
          name="logo"
          label="Company Logo"
          :disabled="personalDisabled"
          :required="false"
        >
          <Error :form-errors="validationErrors?.logo" />
        </FormInput>
      </div>
      <div class="form-group">
        <FormInput
          v-model="password"
          type="password"
          name="password"
          label="Password"
          :disabled="personalDisabled"
          :required="true"
        >
          <Error :form-errors="validationErrors?.password" />
        </FormInput>
      </div>
      <div class="form-group">
        <FormInput
          v-model="password_confirmation"
          type="password"
          name="password_confirmation"
          label="Confirm Password"
          :disabled="personalDisabled"
          :required="true"
        >
          <Error :form-errors="validationErrors?.password_confirmation" />
        </FormInput>
      </div>
      <div class="submit-btns">
        <button v-if="!personalDisabled" type="button" class="btn btn-cancel" @click="togglePersonalForm">
          Cancel
        </button>
        <SubmitButton v-if="!personalDisabled" type="submit" :disabled="loading">
          {{ loading ? 'Saving' : 'Save' }}
        </SubmitButton>
        <SubmitButton v-if="personalDisabled" type="button" @click="togglePersonalForm"> Edit </SubmitButton>
      </div>

      <ErrorAlert :show="!!updateError && !validationErrors" :msg="updateError?.toString() ?? ''" />
    </fieldset>
  </form>
</template>

<style scoped>
legend > h4 {
  margin-block: 0.5rem;
  padding-inline: 0.2rem;
  color: rgba(0, 0, 0, 0.8);
}

div.submit-btns {
  display: flex;
  flex-direction: row;
  flex-wrap: wrap;
  justify-content: flex-end;
  gap: 1rem;
  margin-top: 1rem;
}

label {
  color: rgba(0, 0, 0, 0.85);
  font-size: 0.9rem;
}

button.btn-cancel:hover {
  background-color: rgb(228, 228, 228);
}
</style>
