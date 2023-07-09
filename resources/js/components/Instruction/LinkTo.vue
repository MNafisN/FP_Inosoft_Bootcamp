<template>
    <div class="bg-white w-100 rounded shadow p-3 d-flex gap-2 align-items-end">
        <div class="w-25">
            <label for="link_to" class="fs-7">Link To</label>
            <Dropdown input="Select Item" :selected="linkTo" :list="['satu', 'dua', 'tiga']" :upper="true" @send-value="(value)=> updateLinkTo(value)" />
        </div>
        <div>
            <button class="btn btn-danger fs-7 remove" @click="removeLinkTo">Remove Link</button>
        </div>
    </div>
</template>

<script>
import Dropdown from "./Dropdown.vue";
export default {
    name: 'link-to',
    components: { Dropdown },
    computed: {
        linkTo() {
            return this.$store.getters.getLinkTo
        }
    },
    methods: {
        updateLinkTo(value) {
            this.$store.commit('updateLinkTo', value)
            console.log(this.linkTo);
        },
        removeLinkTo() {
            this.$store.commit('removeLinkTo')
            console.log(this.linkTo)
        }
    }
}
</script>

<style scoped>
.remove{
    height: 38px;
    width: 120px;
}
</style>