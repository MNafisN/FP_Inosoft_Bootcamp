<template>
    <div class="mt-3">
        <div class="w-100 d-flex justify-content-between align-items-center">
            <h5>View Activity Note</h5>
            <div @click="showToggle" class="bg-background-filled rounded size d-flex justify-content-center align-items-center">
                <div :class="isShow ? 'i-up' : 'i-down'"></div>
            </div>
        </div>
        <div v-if="isShow" v-for="log in activityLog" class="row border py-1">
            <div class="col-8">{{ log.action }}</div>
            <div class="col-2">{{ log.by }}</div>
            <div class="col-2 text-end">{{ log.date }}</div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'activity-note',
    data() {
        return {
            isShow: false
        }
    },
    computed: {
        activityLog() {
            return this.$store.getters.getActivityNote
        }
    },
    methods: {
        showToggle() {
            this.isShow === false ? this.isShow = true : this.isShow = false
        }
    }
}
</script>

<style scoped>
.size{
    width: 40px;
    height: 40px;
}
</style>