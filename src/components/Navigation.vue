<template>
    <nav class="navbar container navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Guthand Payment App</a>
        <button
            class="navbar-toggler"
            type="button"
            data-toggle="collapse"
            data-target="#navbarTogglerDemo02"
            aria-controls="navbarTogglerDemo02"
            aria-expanded="false"
            aria-label="Toggle navigation"
        >
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <router-link class="nav-link" to="/dashboard">Übersicht</router-link>
                </li>
                <li class="nav-item">
                    <router-link class="nav-link" to="/transfer">Überweisung</router-link>
                </li>
                <li class="nav-item">
                    <router-link class="nav-link" to="/deposit">Einzahlung</router-link>
                </li>
                <li class="nav-item">
                    <router-link class="nav-link" to="/withdraw">Auszahlung</router-link>
                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="#" class="nav-link" @click.prevent="onLogout">Abmelden</a>
                </li>
            </ul>
        </div>
    </nav>
</template>

<script>
import axios from "axios";

export default {
    name: "Navigation",
    methods: {
        async onLogout() {
            const res = await axios.post("/logout");
        },
    },
};
</script>

<style scoped>
nav {
    margin-bottom: 3em;
}
nav ul.navbar-nav li.nav-item a.router-link-active {
    color: #fff;
    font-weight: bold;
}
</style>
