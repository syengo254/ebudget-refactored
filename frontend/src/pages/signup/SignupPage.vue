<script lang="ts" setup>
import CustomerForm from './components/CustomerForm.vue';
import VendorForm from './components/VendorForm.vue';
</script>

<template>
  <header>
    <div class="logo">
      <img src="" alt="" class="logo-img">
      <span class="tagline">Shop online, let us budget and deliver!</span>
    </div>
    <div class="search-box">
      search here
      <!-- todo laters -->
    </div>
    <div class="navigation-links">
      <nav>
        <a href="http://">Home</a> |
        <a href="http://">About</a> |
        <a href="http://">Sign in</a>
      </nav>
    </div>
  </header>

  <!-- forms -->
  <main>

    <div class="forms">
      <!-- customer sign up form -->
      <CustomerForm />

      <!-- vendor sign up form -->
      <VendorForm />

    </div>

  </main>
</template>

<style scoped>
header {
  z-index: 1;
  width: 100%;
  display: flex;
  justify-content: space-between;
  padding: .5rem 1rem;
  background: blue;
  color: white;
  height: 60px;
  align-items: center;
}

header .tagline {
  font-size: .8rem;
  text-decoration: underline;
  font-weight: bold;
}

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

main {
  margin-top: calc(60px + 1rem);
}
</style>
