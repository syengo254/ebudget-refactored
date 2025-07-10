<script setup lang="ts">
import { computed } from 'vue'
import { RouterLink, useRouter, useRoute } from 'vue-router'
import SearchIcon from '../assets/search.png'
import Logo from '../assets/footer_logo.png'
import MenuBar from '../assets/menu-bar.png'
import { useAuthStore } from '../stores/authStore'

const router = useRouter()
const route = useRoute()

const authStore = useAuthStore()

const showCategoriesBar = computed(() => !['register', 'login', 'profile'].includes(route.name as string))
const isLoggedIn = computed(() => authStore.isLoggedIn)

// handlers
const handleLogout = async () => {
  const success = await authStore.authLogout()
  if (success) {
    router.push({
      path: '/login',
      replace: true,
    })
  }
}
</script>

<template>
  <div class="header-wrapper">
    <header>
      <div class="logo">
        <RouterLink to="/"><img :src="Logo" alt="" class="logo-img" /></RouterLink>
      </div>
      <div class="search-box">
        <form>
          <div class="search-inputs">
            <input id="search" type="search" name="search" placeholder="Search E-budget" />
            <div class="search-icon"><img :src="SearchIcon" alt="search-icon" /></div>
          </div>
        </form>
      </div>
      <div class="navigation-links">
        <div v-if="isLoggedIn" class="user-links">
          <p class="text-md">
            <RouterLink to="/profile" class="text-white decoration-none">Hello, {{ authStore.user?.name }}</RouterLink>
          </p>
          <a class="btn btn-sm" @click.prevent="handleLogout">Logout</a>
        </div>
        <div v-else>
          <nav>
            <RouterLink to="/login">Login</RouterLink>
            <RouterLink to="register">Register</RouterLink>
          </nav>
          <ul class="small-nav">
            <li>
              <RouterLink to="/">Home</RouterLink>
            </li>
            <li>
              <RouterLink to="/login">Login</RouterLink>
            </li>
            <li>
              <RouterLink to="/register">Signup</RouterLink>
            </li>
            <li>
              <RouterLink to="/about">About</RouterLink>
            </li>
          </ul>
        </div>
      </div>
    </header>
  </div>
  <section v-if="showCategoriesBar" id="categories-bar">
    <RouterLink to="/">
      <img class="menu-icon" :src="MenuBar" alt="menu-bar" />
      <span>All</span>
    </RouterLink>
    <nav>
      <RouterLink to="/">Today's Deals</RouterLink>
      <RouterLink to="/">Home</RouterLink>
      <RouterLink to="/about">About</RouterLink>
    </nav>
  </section>
  <main>
    <slot />
  </main>
  <footer>
    <div class="footer-logo"><img :src="Logo" alt="logo" /></div>
    <div class="copyright">&copy; 2024-2050, e-budget.com. All rights reserved.</div>
  </footer>
</template>

<style scoped>
.header-wrapper {
  position: relative;
  width: 100%;
  height: 65px;
}

header {
  position: fixed;
  width: inherit;
  height: inherit;
  display: flex;
  justify-content: space-between;
  padding: 0.5rem 1rem;
  background: rgb(30, 45, 125);
  color: white;
  align-items: center;
  z-index: 100;
}

header .tagline {
  font-size: 0.8rem;
  text-decoration: underline;
  font-weight: bold;
}

div.user-links {
  display: flex;
  flex-direction: row;
  flex-wrap: wrap;
  align-items: center;
  column-gap: 2rem;
  row-gap: 1rem;
  padding-inline: 0.5rem;
}

nav {
  display: inline-flex;
  flex-wrap: wrap;
  column-gap: 2rem;
}

nav > a,
ul.small-nav > li > a {
  color: white;
  text-decoration: none;
  font-size: 1rem;
}

nav > a {
  display: inline-block;
  text-align: center;
}

div.forms {
  display: flex;
  width: fit-content;
  margin-inline: auto;
  gap: 1rem;
}

main {
  padding-inline: 1rem;
  width: auto;
  min-height: calc(100vh - (75px + 2rem));
}

footer {
  position: relative;
  background: rgb(30, 45, 125);
  color: white;
  min-height: 90px;
  padding: 1rem;
  font-size: 0.8rem;
}

footer div.copyright {
  position: absolute;
  bottom: 1rem;
  width: calc(100% - 2rem);
  text-align: center;
}

ul.small-nav {
  margin: 0;
  padding: 0;
  list-style: none;
}

ul.small-nav > li {
  list-style-position: inside;
}

nav > a:hover,
ul.small-nav > li > a:hover {
  text-decoration: underline;
}

div.search-box {
  position: relative;
  max-width: 700px;
  flex-grow: 1;
}

div.search-box > form > div.search-inputs {
  position: relative;
  display: flex;
  align-items: center;
}

input[type='search'] {
  padding-block: 0.5rem;
  padding-left: 1.5rem;
  font-family: 'Roboto', sans-serif;
  font-size: 1rem;
  border: 1px solid blue;
  border-radius: 3.5px 0px 0px 3.5px;
  min-width: 200px;
  letter-spacing: 0.1px;
  outline: none;
  flex: 1;
  margin-left: 2rem;
  border-right: none;
}

input[type='search']:hover,
input[type='search']:focus {
  border: 2px solid rgb(37, 121, 239);
  border-right: none;
}

div.search-icon {
  background-color: rgb(80, 144, 233);
  border-radius: 0px 3.5px 3.5px 0px;
  display: flex;
  align-items: center;
  padding: 1.5px 0.3rem;
  cursor: pointer;
}

div.search-icon:hover {
  background-color: rgb(47, 123, 230);
}

div.search-icon > img {
  width: 32px;
  height: 32px;
  pointer-events: none;
}

/* categories bar styles */
#categories-bar {
  height: 46px;
  background-color: rgb(34, 51, 144);
  border-bottom: 1px solid white;
  display: flex;
  align-items: center;
  padding-left: 1rem;
  color: white;
  gap: 0.5rem;
}

#categories-bar a {
  text-decoration: none;
  padding: 0.5rem 0.5rem;
  display: block;
  box-sizing: content-box;
  border: 1px solid transparent;
}

#categories-bar a:hover {
  text-decoration: none;
  border: 1px solid white;
}

#categories-bar > a:first-of-type {
  display: flex;
  column-gap: 0.5rem;
  align-items: center;
  color: white;
  text-decoration: none;
  outline: none;
}

#categories-bar > a > img.menu-icon {
  width: 24px;
  height: 24px;
  cursor: pointer;
}

#categories-bar > a > span {
  margin-right: 1rem;
  font-weight: bold;
}

/* media queries */
@media screen and (min-width: 700px) {
  ul.small-nav {
    display: none;
  }
}

@media screen and (max-width: 800px) {
  /* 
    add styles as required later
    } */

  header {
    flex-direction: column;
    height: auto;
  }

  nav {
    display: none;
  }

  ul.small-nav {
    display: block;
  }

  main {
    margin-top: calc(20vh + 1rem);
    min-height: calc(58vh);
  }

  input[type='search'] {
    width: auto;
    font-size: 1em;
    margin: 0.5rem;
  }
}
</style>
