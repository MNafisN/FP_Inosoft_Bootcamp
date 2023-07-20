<template>
    <div class="dropdowm">
        <Button
            :type="'primary'"
            :icon="addIcon"
            class="ms-auto my-3 dropdown-toggle"
            data-bs-toggle="dropdown"
            aria-expanded="false"
            >Create 3rd Party Instruction</Button
        >
        <ul class="dropdown-menu w-inherit">
            <li class="dropdown-item" @click="create('Logistic Instruction')">
                <TruckIcon class="icon" />Logistic Instruction
            </li>
            <li class="dropdown-item" @click="create('Service Instruction')">
                <ServiceIcon class="icon" />Service Instruction
            </li>
        </ul>
    </div>
</template>
<script>
import { shallowRef } from "vue";

import Button from "./Button.vue";

import AddIcon from "./Icon/AddIcon.vue";
import ServiceIcon from "./Icon/ServiceIcon.vue";
import TruckIcon from "./Icon/TruckIcon.vue";

export default {
    name: "CreateButton",
    components: { Button, AddIcon, ServiceIcon, TruckIcon },
    data() {
        return {
            addIcon: shallowRef(AddIcon),
        };
    },
    methods: {
        create(type) {
            this.$store.commit('reset')
            this.$store.commit('updateInstructionType', type)
            this.$router.push('/app/create-instruction')
        }
    }
};
</script>

<style scoped>
.icon {
    margin-right: 10px;
    color: #00bfbf;
}
</style>
