<template>
    <div class="bg-info-subtle">
        <Header></Header>
        <div class="m-4">
            <RouterView></RouterView>
        </div>
    </div>
</template>
<script>
import Header from './components/Header.vue'
    export default {
        name: 'App',
        components: {Header}
    }
</script>