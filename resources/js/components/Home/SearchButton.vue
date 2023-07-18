<template>
    <Button :icon="searchIcon" @click="clickActive()" class="h-100 me-2">
        <form @submit.prevent="search">
            <input
                v-if="active"
                type="text"
                class="input"
                v-model="inputSearch"
                aria-controls="DataTables_Table_3"
            />
        </form>
    </Button>
</template>
<script>
import { shallowRef } from "vue";

import Button from "./Button.vue";

import SearchIcon from "./Icon/SearchIcon.vue";

export default {
    name: "SearchButton",
    components: { Button, SearchIcon },
    emits: ['search'],
    data() {
        return {
            searchIcon: shallowRef(SearchIcon),
            active: false,
            inputSearch: "",
        };
    },
    methods: {
        clickActive() {
            this.active = true;
        },
        search() {
            this.$store.commit('setSearchInput', this.inputSearch);
            this.$emit('search')
        },
    },
};
</script>

<style scoped>
.input {
    border: 0 !important;
    outline: 0 !important;
    line-height: 10px;
}
</style>
