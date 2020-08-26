<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <router-link class="navbar-brand" to="/">Payment App</router-link>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="container collapse navbar-collapse" id="navbarNav">
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
                    <a href="#" class="nav-link">Abmelden</a>
                </li>
            </ul>
        </div>
    </nav>
</template>

<style scoped>
nav {
    margin-bottom: 3em;
}
nav ul.navbar-nav li.nav-item a.router-link-active {
    color: rgba(0,0,0,.9);
}
</style>