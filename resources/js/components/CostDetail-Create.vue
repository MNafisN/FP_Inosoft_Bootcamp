<template>
    <h5>cost detail</h5>
    <div class="p-2">
        <div class="row bg-secondary text-white">
            <div class="col fg-1">Description</div>
            <div class="col fg-2">QTY</div>
            <div class="col fg-3">UOM</div>
            <div class="col fg-4">Unit Price</div>
            <div class="col fg-5">GST(%)</div>
            <div class="col fg-6"></div>
            <div class="col fg-7">Currency</div>
            <div class="col fg-8 text-end">Val Amount</div>
            <div class="col fg-9 text-end">Sub Total</div>
            <div class="col fg-10 text-end">Total</div>
            <div class="col fg-11">Charge To</div>
            <div class="col fg-12"></div>
        </div>
        <CostTable v-for="(n, i) in listCostTable" :index="i" />
        <div class="d-flex justify-content-end">
            <div class="plus bg-secondary" @click="plus">
                <div class="i-plus"></div>
            </div>
        </div>
    </div>
</template>

<script>
import CostTable from './CostTable.vue';
export default {
    name: 'cost-detail-create',
    components: { CostTable },
    methods: {
        plus() {
            this.$store.commit('addCostList')
        }
    },
    computed: {
        costData() {
            return this.$store.getters.CostTable
        },
        listCostTable() {
            return this.$store.getters.listCostTable
        }
    }
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
    flex-grow: 0.7;
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

.minus {
    width: 38px;
    height: 38px;
    border-radius: 0.375rem;
    display: flex;
    justify-content: center;
    align-items: center;
}

.plus {
    width: 38px;
    height: 38px;
    border-radius: 0.375rem;
    display: flex;
    justify-content: center;
    align-items: center;
    margin-right: -0.25rem;
    margin-top: 0.5rem;
}</style>