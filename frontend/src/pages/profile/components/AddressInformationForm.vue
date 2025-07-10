<script setup lang="ts">
import { ref } from 'vue'

import FormInput from '../../../components/forms/FormInput.vue'
import Error from '../../../components/forms/Error.vue'
import SubmitButton from './SubmitButton.vue'
import ErrorAlert from '../../../components/ErrorAlert.vue'
import useProfile from '../../../composables/useProfile'
import { useAuthStore } from '../../../stores/authStore'
import SuccessAlert from '../../../components/SuccessAlert.vue'

const authStore = useAuthStore()
const { addUserAddress, apiData, apiError, formErrors, apiLoading, apiSuccess } = useProfile()

const phone = ref(authStore.user?.profile?.phone ?? '')
const city = ref(authStore.user?.address?.city ?? '')
const town = ref(authStore.user?.address?.town ?? '')
const building = ref(authStore.user?.address?.building ?? '')
const floor = ref(authStore.user?.address?.floor ?? '')
const additional_info = ref(authStore.user?.address?.additional_info ?? '')
const addressDisabled = ref(true)

const validationErrors = ref<{
  phone: string[]
  city: string[]
  town: string[]
  building: string[]
  floor: string[]
  additional_info: string[]
} | null>(null)

// handlers

async function handleSubmit() {
  await addUserAddress({
    phone: phone.value,
    city: city.value,
    town: town.value,
    building: building.value,
    floor: floor.value,
    additional_info: additional_info.value,
  })

  if (apiSuccess.value) {
    if (apiData.value?.success && apiData.value?.user) {
      authStore.setUser(apiData.value?.user, true)
    }
    toggleAddressForm('cancel')
  } else {
    if (formErrors.value) {
      validationErrors.value = formErrors.value
    }
  }
}

function toggleAddressForm(src: 'edit' | 'cancel' = 'edit') {
  addressDisabled.value = !addressDisabled.value

  if (src == 'cancel') {
    resetFormValues()
  }
}

function resetFormValues() {
  phone.value = authStore.user?.profile?.phone ?? ''
  city.value = authStore.user?.address?.city ?? ''
  town.value = authStore.user?.address?.town ?? ''
  building.value = authStore.user?.address?.building ?? ''
  floor.value = authStore.user?.address?.floor ?? ''
  additional_info.value = authStore.user?.address?.additional_info ?? ''
  validationErrors.value = null
}
</script>

<template>
  <form action="/profiles" method="post" enctype="application/x-www-form-urlencoded" @submit.prevent="handleSubmit">
    <fieldset>
      <legend><h4>Addressing & Contact Information</h4></legend>
      <div class="form-group">
        <FormInput
          v-model="phone"
          label="Phone"
          name="phone"
          type="text"
          autocomplete="phone"
          placeholder="+254 720 000 000"
          required
          :disabled="addressDisabled"
        >
          <Error :form-errors="validationErrors?.phone" />
        </FormInput>
      </div>
      <div class="flex flex-row gap-2 flex-wrap">
        <div class="form-group" style="flex-grow: 1">
          <FormInput
            v-model="city"
            label="City"
            name="city"
            autocomplete="city"
            placeholder="e.g. Nairobi"
            required
            :disabled="addressDisabled"
          >
            <Error :form-errors="validationErrors?.city" />
          </FormInput>
        </div>
        <div class="form-group" style="flex-grow: 1">
          <FormInput
            v-model="town"
            label="Town"
            name="town"
            autocomplete="town"
            placeholder="e.g. Lang'ata"
            :disabled="addressDisabled"
          >
            <Error :form-errors="validationErrors?.town" />
          </FormInput>
        </div>
      </div>
      <div class="flex flex-row gap-2 flex-wrap">
        <div class="form-group" style="flex-grow: 1">
          <FormInput v-model="building" label="Building" name="building" :disabled="addressDisabled">
            <Error :form-errors="validationErrors?.building" />
          </FormInput>
        </div>
        <div class="form-group">
          <FormInput v-model="floor" label="Floor & Door number" name="floor" :disabled="addressDisabled">
            <Error :form-errors="validationErrors?.town" />
          </FormInput>
        </div>
      </div>
      <div class="form-group">
        <label for="additional_info">Additional information (Optional)</label>
        <textarea
          id="additional_info"
          v-model="additional_info"
          rows="4"
          class="form-input"
          :disabled="addressDisabled"
        >
                <!-- extra addressing information here -->
              </textarea
        >
        <Error :form-errors="validationErrors?.additional_info" />
      </div>

      <div class="submit-btns">
        <button v-if="!addressDisabled" type="button" class="btn btn-cancel" @click="toggleAddressForm('cancel')">
          Cancel
        </button>
        <SubmitButton v-if="!addressDisabled" :disabled="apiLoading">
          {{ apiLoading ? 'Saving' : 'Save' }}
        </SubmitButton>
        <SubmitButton v-if="addressDisabled" type="button" @click="toggleAddressForm">Edit</SubmitButton>
      </div>

      <SuccessAlert msg="Account details updated." :show="apiSuccess" />
      <ErrorAlert :show="!!apiError && !validationErrors" :msg="apiError?.message ?? ''" />
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
