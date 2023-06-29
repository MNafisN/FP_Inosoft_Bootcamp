<template>
    <Button :icon="searchIcon" @click="clickActive()" class="h-100 me-2">
        <input v-if="active" type="text" class="input" />
    </Button>
</template>
<script>
import { shallowRef } from "vue";

import Button from "./Button.vue";

import SearchIcon from "./Icon/SearchIcon.vue";

export default {
    name: "SearchButton",
    components: { Button, SearchIcon },
    data() {
        return {
            searchIcon: shallowRef(SearchIcon),
            active: false,
        };
    },
    methods: {
        clickActive() {
            this.active = true;
        },
    },
};
</script>

<style scoped>
.input {
    border: 0 !important;
    outline: 0 !important;
}
</style>
