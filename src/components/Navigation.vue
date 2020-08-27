<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container collapse navbar-collapse" id="navbarNav">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <ul class="navbar-nav my-2 my-lg-0">
                <router-link class="navbar-brand" to="/">Payment App</router-link>
            </ul>
            <ul class="navbar-nav">
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
            <ul class="navbar-nav my-2 my-lg-0">
                <li class="nav-item">
                    <a href="#" class="nav-link" @click.prevent="onLogout">Abmelden</a>
                </li>
            </ul>
        </div>
    </nav>
</template>

<script>
import axios from 'axios';

export default {
    name: 'Navigation',
    methods: {
        async onLogout() {
            const res = await axios.post('/logout');
        },
    },
};
</script>

<style scoped>
nav {
    margin-bottom: 3em;
}
nav ul.navbar-nav li.nav-item a.router-link-active {
    color: rgba(0,0,0,.9);
}
</style>