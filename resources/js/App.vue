<template>
    <div class="bg-info-subtle">
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
            const token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYXBpL2F1dGgvbG9naW4iLCJpYXQiOjE2ODkzODk4MjQsImV4cCI6MTY4OTM5MzQyNCwibmJmIjoxNjg5Mzg5ODI0LCJqdGkiOiI1TnJJSkRyQVNWYjc2RGFoIiwic3ViIjoiNjRhZmZjZWQ1Nzg3ZmJhODEwMDA1OWMzIiwicHJ2IjoiMjNiZDVjODk0OWY2MDBhZGIzOWU3MDFjNDAwODcyZGI3YTU5NzZmNyJ9.76hEOJQCymqDvL5noCAFWVFG2PGThS4HxcBYEmEeTjw"
            axios.defaults.headers.common['Authorization'] = `Bearer ${token}`
        }
    }
</script>