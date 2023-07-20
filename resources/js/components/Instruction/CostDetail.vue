<template>
    <h5>cost detail</h5>
    <div class="p-2">
        <div class="row bg-secondary-custom text-white">
            <div class="col fg-1">Description</div>
            <div :class="'col fg-2 ' + (type === 'detail' ? 'text-end' : '')">QTY</div>
            <div class="col fg-3">UOM</div>
            <div :class="'col fg-4 ' + (type === 'detail' ? 'text-end' : '')">Unit Price</div>
            <div :class="'col fg-5 ' + (type === 'detail' ? 'text-end' : '')">GST(%)</div>
            <div class="col fg-6"></div>
            <div class="col fg-7">Currency</div>
            <div class="col fg-8 text-end">Val Amount</div>
            <div class="col fg-9 text-end">Sub Total</div>
            <div class="col fg-10 text-end">Total</div>
            <div class="col fg-11">Charge To</div>
            <div class="col fg-12"></div>
        </div>
        <CostTable v-for="(n, i) in listCostTable" :index="i" :type="type" />
        <UsdTotal v-if="UsdCheck" :type="type" />
        <AudTotal v-if="AudCheck" :type="type" :UsdCheck="UsdCheck" />
        <div v-if="!UsdCheck && !AudCheck && type !== 'detail'" class="d-flex py-2 justify-content-end w-100">
            <div class="plus bg-primary-custom" @click="plus">
                <div class="i-plus"></div>
            </div>
        </div>
    </div>
</template>

<script>
import CostTable from './CostTable.vue';
import UsdTotal from './UsdTotal.vue';
import AudTotal from './AudTotal.vue';
export default {
    name: 'cost-detail-create',
    components: { CostTable, UsdTotal, AudTotal },
    props: {
        type: String
    },
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
        },
        AudCheck() {
            return this.$store.getters.AudCheck
        },
        UsdCheck() {
            return this.$store.getters.UsdCheck
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
    margin-right: -5px;
}</style>