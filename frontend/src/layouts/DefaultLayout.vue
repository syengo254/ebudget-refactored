<script setup lang="ts">
import { RouterLink } from 'vue-router'
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
                <RouterLink to="/">Home</RouterLink> |
                <RouterLink to="/signin">Login</RouterLink> |
                <RouterLink to="/signup">Signup</RouterLink> |
                <RouterLink to="/about">About</RouterLink>
            </nav>
            <ul class="small-nav">
                <li>
                    <RouterLink to="/">Home</RouterLink>
                </li>
                <li>
                    <RouterLink to="/signin">Login</RouterLink>
                </li>
                <li>
                    <RouterLink to="/signup">Signup</RouterLink>
                </li>
                <li>
                    <RouterLink to="/about">About</RouterLink>
                </li>
            </ul>
        </div>
    </header>
    <main>
        <slot></slot>
    </main>
    <footer>
        <div class="copyright">&copy; 2024-2050, e-budget.com. All rights reserved.</div>
    </footer>
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

nav>a,
ul.small-nav>li>a {
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
    padding-inline: 1rem;
    width: auto;
    min-height: calc(90vh - (60px + 2rem));
}

footer {
    position: relative;
    background: blue;
    color: white;
    min-height: 120px;
    padding: 1rem;
    font-size: .8rem;
}

footer div.copyright {
    position: absolute;
    bottom: 5px;
    width: calc(100% - 2rem);
    text-align: center;
}

ul.small-nav {
    margin: 0;
    padding: 0;
    list-style: none;
}

ul.small-nav>li {
    list-style-position: inside;
}

ul.small-nav>li>a:hover {
    text-decoration: underline;
}

@media screen and (min-width: 600px) {
    ul.small-nav {
        display: none;
    }
}

@media screen and (max-width: 600px) {

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
}
</style>
