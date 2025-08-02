<script setup lang="ts"></script>

<template>
  <main>
    <div><h2>Staff Area</h2></div>
    <router-link :to="{ name: 'staff-login' }">Login?</router-link>
    <router-view />
  </main>
</template>

<style scoped></style>
