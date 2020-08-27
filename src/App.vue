<template>
    <div>
        <div id="app" v-if="logged_in">
            <Navigation/>
            <div class="container">
                <transition name="fade" mode="out-in">
                    <router-view/>
                </transition>
            </div>
        </div>
        <div id="login" v-else>
            <Login/>
        </div>
    </div>
</template>

<script>
import Navigation from './components/Navigation.vue';
import Login from './components/Login.vue';
import axios from 'axios';

export default {
    name: 'App',
    components: {
        Navigation,
        Login,
    },
    data() {
        return {
            logged_in: false,
        }
    },
    async created() {
        const res = await axios.post('/loggedin');
        this.logged_in = res.data.data.logged_in;
    },
};
</script>

<style>
body {
    overflow-y: scroll;
}

.fade-enter-active,
.fade-leave-active {
  transition-duration: 200ms;
  transition-property: opacity;
  transition-timing-function: ease;
}

.fade-enter,
.fade-leave-active {
  opacity: 0
}
</style>
