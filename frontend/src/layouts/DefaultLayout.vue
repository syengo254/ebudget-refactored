<script setup lang="ts">
import { RouterLink } from 'vue-router';
import SearchIcon from '../assets/search.png';
import Logo from '../assets/footer_logo.png';
import MenuBar from '../assets/menu-bar.png';

const categories = [
    {
        id: 1,
        name: "furniture",
        subcategories: [
            {
                id: 23,
                name: "tables",
            },
        ]
    },
    {
        id: 1,
        name: "furniture",
        subcategories: [
            {
                id: 23,
                name: "tables",
            },
        ]
    },
]
</script>

<template>
    <div class="header-wrapper">
        <header>
            <div class="logo">
                <img :src="Logo" alt="" class="logo-img">
                <!-- <span class="tagline">Shop online, let us budget and deliver!</span> -->
            </div>
            <div class="search-box">
                <form>
                    <div class="search-inputs">
                        <input type="search" name="search" id="search" placeholder="Search E-budget">
                        <div class="search-icon"><img :src="SearchIcon" alt="search-icon" /></div>
                    </div>
                </form>
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
    </div>
    <section id="categories-bar">
        <img class="menu-icon" :src="MenuBar" alt="menu-bar" />
        <span>All</span>
    </section>
    <main>
        <slot></slot>
    </main>
    <footer>
        <div class="footer-logo"><img :src="Logo" alt="logo"></div>
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
    padding: .5rem 1rem;
    background: blue;
    color: white;
    align-items: center;
    z-index: 2;
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

nav>a {
    width: 70px;
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
    background: blue;
    color: white;
    min-height: 90px;
    padding: 1rem;
    font-size: .8rem;
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

ul.small-nav>li {
    list-style-position: inside;
}

nav>a:hover,
ul.small-nav>li>a:hover {
    text-decoration: underline;
}

div.search-box {
    position: relative;
    flex-grow: 1;
    margin-inline: .5rem;
}

div.search-box>form>div.search-inputs {
    position: relative;
    flex: 1;
    display: flex;
    align-items: center;
}

input[type="search"] {
    padding-block: .5rem;
    padding-left: 1.5rem;
    font-family: 'Roboto', sans-serif;
    font-size: 1rem;
    border: 1px solid blue;
    border-radius: 3.5px 0px 0px 3.5px;
    min-width: 400px;
    letter-spacing: .1px;
    outline: none;
    flex: 1;
    margin-left: 2rem;
    border-right: none;
}

input[type="search"]:hover,
input[type="search"]:focus {
    border: 2px solid rgb(37, 121, 239);
    border-right: none;
}

div.search-icon {
    background-color: rgb(80, 144, 233);
    border-radius: 0px 3.5px 3.5px 0px;
    display: flex;
    align-items: center;
    padding: 1.5px .3rem;
    cursor: pointer;
}

div.search-icon:hover {
    background-color: rgb(47, 123, 230);
}

div.search-icon>img {
    width: 32px;
    height: 32px;
    pointer-events: none;
}

/* categories bar styles */
#categories-bar {
    height: 46px;
    background-color: rgb(35, 75, 255);
    border-bottom: 1px solid white;
    display: flex;
    align-items: center;
    padding-left: 1rem;
    color: white;
    gap: .5rem;
}

#categories-bar>img.menu-icon {
    width: 24px;
    height: 24px;
    cursor: pointer;
}

#categories-bar>span {
    font-weight: bold;
}

/* media queries */
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

    input[type="search"] {
        width: auto;
        font-size: 1em;
        margin: .5rem;
    }
}
</style>
