<script lang="ts" setup>
import CustomerForm from './components/CustomerForm.vue';
import VendorForm from './components/VendorForm.vue';
</script>

<template>
  <!-- forms -->
  <div class="forms">
    <!-- customer sign up form -->
    <CustomerForm />

    <!-- vendor sign up form -->
    <VendorForm />

  </div>
</template>

<style scoped>
nav>a {
  color: white;
  text-decoration: none;
  font-size: 1rem;
}

div.forms {
  display: flex;
  width: fit-content;
  margin-inline: auto;
  gap: 1rem;
}

@media screen and (max-width: 600px) {
  div.forms {
    flex-direction: column;
  }
}
</style>
