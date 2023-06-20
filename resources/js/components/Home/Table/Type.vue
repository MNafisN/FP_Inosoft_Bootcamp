<template>
    <div v-if="type === 'Service Instruction'">
        <ServiceIcon viewBox="0 0 26 26" class="type" /> SI
    </div>
    <div v-else><TruckIcon viewBox="0 0 26 26" class="type" /> LI</div>
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

<style scoped>
.type {
    color: #a6afb7;
}
</style>
