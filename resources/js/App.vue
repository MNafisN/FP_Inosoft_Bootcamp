<template>
    <div class="bg-background">
        <Header></Header>
        <div class="m-4 mb-0">
            <RouterView></RouterView>
        </div>
    </div>
</template>
<script>
import axios from 'axios';
import Header from './components/Header.vue'
    export default {
        name: 'App',
        components: {Header},
        created() {
            const token = localStorage.getItem('acces_token')
            axios.defaults.headers.common['Authorization'] = `Bearer ${token}`
        }
    }
</script>