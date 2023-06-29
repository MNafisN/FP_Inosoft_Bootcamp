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
            <li>
                <router-link class="dropdown-item" to="/app/create-instruction"
                    ><TruckIcon class="icon" />Logistic Instruction</router-link
                >
            </li>
            <li>
                <router-link class="dropdown-item" to="/app/create-instruction"
                    ><ServiceIcon class="icon" />Service
                    Instruction</router-link
                >
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
};
</script>

<style scoped>
.icon {
    margin-right: 10px;
    color: #00bfbf;
}
</style>
