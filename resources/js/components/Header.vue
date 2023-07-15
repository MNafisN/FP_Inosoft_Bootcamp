<template>
    <header class="w-100 py-2 px-3 bg-dark d-flex justify-content-between">
        <p class="text-white fs-4 m-0">Team 2</p>
        <button class="btn btn-secondary" @click="logout">Log Out</button>
    </header>
</template>

<script>
export default {
    methods: {
        logout() {
            localStorage.removeItem('access_token');
            this.$router.push('/app/login');
        },
    },
};
</script>