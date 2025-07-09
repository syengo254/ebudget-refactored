<script setup lang="ts">
import { ref } from 'vue'
import FormInput from '../../../components/forms/FormInput.vue'
import Error from '../../../components/forms/Error.vue'
import SubmitButton from './SubmitButton.vue'
import ErrorAlert from '../../../components/ErrorAlert.vue'

const phone = ref('')
const city = ref('')
const town = ref('')
const building = ref('')
const floor = ref('')
const additional_info = ref('')

const loading = ref(false)
const addressDisabled = ref(true)

const validationErrors = ref<{
  phone: string[]
  city: string[]
  town: string[]
  building: string[]
  floor: string[]
  additional_info: string[]
} | null>(null)
const updateError = ref<null | boolean | string>(null)

// handlers

function toggleAddressForm() {
  addressDisabled.value = !addressDisabled.value
}
</script>

<template>
  <form action="/profile" method="post">
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
        <button v-if="!addressDisabled" type="button" class="btn btn-cancel" @click="toggleAddressForm">Cancel</button>
        <SubmitButton v-if="!addressDisabled" :disabled="loading">
          {{ loading ? 'Saving' : 'Save' }}
        </SubmitButton>
        <SubmitButton v-if="addressDisabled" type="button" @click="toggleAddressForm">Edit</SubmitButton>
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
