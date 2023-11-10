<script lang="ts" setup>
import CustomerForm from './components/CustomerForm.vue';
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

    </div>

  </main>
</template>

<style scoped>
header {
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
</style>
