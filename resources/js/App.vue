<template>
    <RouterLink to="/app">Home</RouterLink>|
    <RouterLink to="/app/about">About</RouterLink>
    <RouterView></RouterView>
    <span><button class="btn btn-primary" @click="decrement">-</button> {{ count }} <button class="btn btn-danger" @click="increment">+</button></span>
</template>
<script>
    export default {
        name: 'App',
        computed: {
            count() {
                return this.$store.getters.count
            }
        },
        methods: {
            increment() {
                this.$store.dispatch("increment")
            },
            decrement() {
                this.$store.dispatch("decrement")
            }
        }
    }
</script>