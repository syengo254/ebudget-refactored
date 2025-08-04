<script setup lang="ts"></script>

<template>
  <section id="main">
    <h4>Seems you have found the portal to nowhere</h4>

    <p>You are ambitious but we cannot take you to your destination.</p>

    <RouterLink :to="{ name: 'home' }">Go Back to Home</RouterLink>
  </section>
</template>

<style scoped>
section#main {
  position: relative;
  text-align: center;
  margin-top: auto;
  height: 300px;
}
</style>
