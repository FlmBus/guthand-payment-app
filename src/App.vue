<template>
    <div id="app">
        <Navigation/>
        <div class="container">
            <transition name="fade" mode="out-in">
                <router-view/>
            </transition>
        </div>
    </div>
</template>

<script>
import Navigation from './components/Navigation.vue';

export default {
    name: 'App',
    components: {
        Navigation,
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
