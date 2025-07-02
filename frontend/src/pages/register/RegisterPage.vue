<script lang="ts" setup>
import RegisterForm from './components/RegisterForm.vue'
</script>

<template>
  <!-- forms -->
  <div class="forms">
    <!-- customer sign up form -->
    <RegisterForm form-title="Customer" />

    <!-- vendor sign up form -->
    <RegisterForm form-title="Vendor" />
  </div>
</template>

<style scoped>
nav > a {
  color: white;
  text-decoration: none;
  font-size: 1rem;
}

div.forms {
  display: flex;
  width: fit-content;
  margin-inline: auto;
  column-gap: 10rem;
  row-gap: 2rem;
  margin-top: 2em;
}

@media screen and (max-width: 600px) {
  div.forms {
    flex-direction: column;
  }
}
</style>
