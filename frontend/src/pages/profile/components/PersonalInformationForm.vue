<script lang="ts" setup>
import { computed, ref } from 'vue'
import Error from '../../../components/forms/Error.vue'
import FormInput from '../../../components/forms/FormInput.vue'
import SubmitButton from './SubmitButton.vue'
import ErrorAlert from '../../../components/ErrorAlert.vue'
import { useAuthStore } from '../../../stores/authStore'
import SuccessAlert from '../../../components/SuccessAlert.vue'
import { UserUpdateType } from '../../../types'
import { getRandomNumber } from '../../../utils/helpers'

const authStore = useAuthStore()

const name = ref(authStore.user?.name)
const logo = ref<File | null>(null)
const password = ref('')
const password_confirmation = ref('')
const showChangePassword = ref(false)
const hasLogo = computed(() => authStore.user?.hasStore && logo.value)
const passwordChanged = computed(() => showChangePassword.value && (password.value as string).length > 0)
const updating = ref(false)
const success = ref(false)
const randomKey = ref(getRandomNumber(1000))

const personalDisabled = ref(true)

const updateError = ref<null | boolean | string>(null)

const validationErrors = ref<{
  password?: string[]
  password_confirmation?: string[]
  name?: string[]
  logo?: string[]
} | null>(null)

function togglePersonalForm(src: 'cancel' | 'edit' = 'edit') {
  personalDisabled.value = !personalDisabled.value

  if (src == 'cancel') {
    name.value = authStore.user?.name
    password.value = ''
    password_confirmation.value = ''
    showChangePassword.value = false
    logo.value = null
    randomKey.value = getRandomNumber()

    if (validationErrors.value) validationErrors.value = null
  }
}

async function handleSubmit() {
  if (name.value == '') {
    validationErrors.value = {
      name: ['Name cannot be empty'],
    }
    return
  }

  if (passwordChanged.value) {
    if ((name.value as string).length < 8) {
      validationErrors.value = {
        name: ['Minimum  of 8 characters required'],
      }
      return
    }

    if ((password.value as string).length < 6) {
      validationErrors.value = {
        name: ['Minimum 6 characters for password'],
      }
      return
    }

    if (password.value !== password_confirmation.value) {
      validationErrors.value = {
        password: ['Passwords do not match!'],
      }
      return
    }
  }

  let formData: UserUpdateType | FormData = {
    ...(name.value ? { name: name.value } : {}),
    ...(showChangePassword.value
      ? { password: password.value, password_confirmation: password_confirmation.value }
      : {}),
  }

  if (hasLogo.value && logo.value) {
    formData = new FormData()
    formData.append('logo', logo.value)
    formData.append('name', name.value as string)
    if (passwordChanged.value) {
      formData.append('password', password.value)
      formData.append('password_confirmation', password_confirmation.value)
    }
  }

  updating.value = true
  validationErrors.value = null
  updateError.value = null

  const { success: done, loading, error, errors } = await authStore.updateUser(formData)

  if (done.value) {
    // show alert success
    success.value = done.value
    togglePersonalForm('cancel')
  } else if (errors.value !== null) {
    validationErrors.value = errors.value
  } else {
    // show error alert
    updateError.value = error.value
  }
  updating.value = loading.value
}

function handleFileChange(event: string | undefined) {
  if (event !== 'logo') return

  const target = document.getElementById(event) as HTMLInputElement
  if (target && target.files && target.files.length > 0) {
    logo.value = target.files[0]
    if (logo.value.size > 1000 * 1000 * 5) {
      validationErrors.value = {
        logo: ['File size cannot be more than 5MB'],
      }
      logo.value = null
      randomKey.value = getRandomNumber()
    } else {
      if (validationErrors.value) validationErrors.value.logo = []
    }
  } else {
    logo.value = null
  }
}
</script>

<template>
  <form action="/profile" method="post" autocomplete="off" enctype="multipart/form-data" @submit.prevent="handleSubmit">
    <fieldset>
      <legend><h4>Personal Information</h4></legend>
      <div v-show="!authStore.user?.verified" class="form-group">
        <Error :form-errors="['You have not verified your account email address yet!']" />
        <div class="mb-1 text-sm">
          <RouterLink :to="{ name: 'verify-account', query: { redirect: '/profile' } }"
            >Click here to verify</RouterLink
          >
        </div>
      </div>
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
      <div v-show="authStore.user?.hasStore" class="form-group">
        <FormInput
          :key="randomKey"
          type="file"
          name="logo"
          label="Company Logo (Square dimensions e.g. 128x128 pixels)"
          :disabled="personalDisabled"
          :required="false"
          @file-changed="handleFileChange"
        >
          <Error :form-errors="validationErrors?.logo" />
        </FormInput>
      </div>
      <div v-if="showChangePassword">
        <div class="form-group">
          <FormInput
            v-model="password"
            type="password"
            name="password"
            label="Password"
            :disabled="personalDisabled"
            :required="false"
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
            :required="false"
          >
            <Error :form-errors="validationErrors?.password_confirmation" />
          </FormInput>
        </div>
      </div>
      <div v-else>
        <SubmitButton
          type="button"
          @click="
            () => {
              showChangePassword = !showChangePassword
              togglePersonalForm()
            }
          "
          >Change Password</SubmitButton
        >
      </div>
      <div class="submit-btns">
        <button v-if="!personalDisabled" type="button" class="btn btn-cancel" @click="togglePersonalForm('cancel')">
          Cancel
        </button>
        <SubmitButton v-if="!personalDisabled" type="submit" :disabled="updating">
          {{ updating ? 'Saving' : 'Save' }}
        </SubmitButton>
        <SubmitButton v-if="personalDisabled" type="button" @click="togglePersonalForm"> Edit </SubmitButton>
      </div>

      <ErrorAlert :show="!success && !!updateError" :msg="updateError?.toString() ?? ''" />
      <SuccessAlert
        msg="Account details updated. You will need to login again if you changed your password"
        :show="success"
      />
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
