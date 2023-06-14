<template>
    <div v-if="type === 'si'"><ServiceIcon /> SI</div>
    <div v-else><TruckIcon /> LI</div>
</template>

<script>
import ServiceIcon from "../Icon/ServiceIcon.vue";
import TruckIcon from "../Icon/TruckIcon.vue";

export default {
    components: { ServiceIcon, TruckIcon },
    props: {
        type: {
            type: String,
            required: true,
        },
    },
};
</script>

<style></style>
