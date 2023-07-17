<template>
    <div class="row height">
        <div class="col fg-1"></div>
        <div class="col fg-2"></div>
        <div class="col fg-3"></div>
        <div class="col fg-4"></div>
        <div class="col fg-5"></div>
        <div class="col fg-6"></div>
        <div
            class="col fg-7 d-flex justify-content-end align-items-center bg-background-filled"
        >
            <span><b>USD </b>(total)</span>
        </div>
        <div
            class="col fg-8 d-flex justify-content-end align-items-center bg-background-filled"
        >   
            <span  class="fw-bold">{{ CostTotal.vat_amount }}</span>
        </div>
        <div
            class="col fg-9 d-flex justify-content-end align-items-center bg-background-filled"
        >
            <span class="fw-bold">{{ CostTotal.sub_total }}</span>
        </div>
        <div
            class="col fg-10 d-flex justify-content-end align-items-center bg-background-filled"
        >
            <span class="fw-bold">{{ CostTotal.total }}</span>
        </div>
        <div class="col fg-11"></div>
        <div class="col fg-12 py-2">
            <div v-if="type !== 'detail'" class="plus bg-primary-custom" @click="plus">
                <div class="i-plus"></div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'usd-total',
    props: {
        type: String
    },
    methods: {
        plus() {
            this.$store.commit('addCostList')
        }
    },
    computed: {
        CostTotal() {
            return this.$store.getters.getUsdTotal
        },
    },
}
</script>

<style scoped>
.col {
    padding-left: 0.5rem;
    padding-right: 0.5rem;
}

.fg-1 {
    flex-grow: 1.5;
}

.fg-2 {
    flex-grow: 1;
}

.fg-3 {
    flex-grow: 0.7;
}

.fg-4 {
    flex-grow: 1.2;
}

.fg-5 {
    flex-grow: 0.7;
}

.fg-6 {
    flex-grow: 0.1;
}

.fg-7 {
    flex-grow: 0.8;
}

.fg-8 {
    flex-grow: 1;
}

.fg-9 {
    flex-grow: 1;
}

.fg-10 {
    flex-grow: 1;
}

.fg-11 {
    flex-grow: 1.2;
}

.fg-12 {
    flex-grow: 0.35;
}


.plus {
    width: 38px;
    height: 38px;
    border-radius: 0.375rem;
    display: flex;
    justify-content: center;
    align-items: center;
}
.height{
    min-height: 54px;
}
</style>