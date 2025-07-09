<script setup lang="ts">
import AddressInformationForm from './components/AddressInformationForm.vue'
import PersonalInformationForm from './components/PersonalInformationForm.vue'
</script>

<template>
  <section class="main">
    <h3>My Account Details</h3>
    <p>You can update your account information here</p>

    <div class="flex flex-row flex-wrap gap-2">
      <div class="profile-info">
        <PersonalInformationForm />
      </div>
      <div class="profile-info">
        <AddressInformationForm />
      </div>
    </div>
  </section>
</template>

<style scoped>
section.main {
  position: relative;
  padding-inline: 1rem;
  max-width: 1400px;
  margin-inline: auto;
  margin-bottom: 2rem;
}

.profile-info {
  position: relative;
  min-width: 300px;
  max-width: 650px;
  width: auto;
  flex-grow: 1;
  padding-bottom: 1rem;
}
</style>
