<template>
    <div v-if="type === 'detail'" class="row py-2 border">
        <div class="col py-2 fg-1">
            <p class="m-0">{{ costData.cost_description }}</p>
        </div>
        <div class="col py-2 fg-2">
            <p class="m-0 text-end">{{ costData.quantity }}</p>
        </div>
        <div class="col py-2 fg-3">
            <p class="m-0">{{ costData.unit_of_measurement }}</p>
        </div>
        <div class="col py-2 fg-4">
            <p class="m-0 text-end">{{ costData.unit_price }}</p>
        </div>
        <div class="col py-2 fg-5">
            <p class="m-0 text-end">{{ costData.GST_percentage }}</p>
        </div>
        <div class="col py-2 fg-6">
            <div class="i-arrow-right"></div>
        </div>
        <div class="col py-2 fg-7">
            <p class="m-0">{{ costData.currency }}</p>
        </div>
        <div class="col py-2 fg-8">
            <p class="m-0 text-end">{{ costData.vat_amount }}</p>
        </div>
        <div class="col py-2 fg-8">
            <p class="m-0 text-end">{{ costData.sub_total }}</p>
        </div>
        <div class="col py-2 fg-8">
            <p class="m-0 text-end">{{ costData.total }}</p>
        </div>
        <div class="col py-2 fg-11">
            <p class="m-0">{{ costData.charge_to }}</p>
        </div>
        <div class="col py-2 fg-12">
        </div>
    </div>
    <div v-else class="row py-2 border">
        <div class="col fg-1">
            <input
                type="text"
                :value="costData.cost_description"
                @input="(e) => updateCostDescription(e.target.value)"
                class="form-control"
                placeholder="Enter Description"
            />
        </div>
        <div class="col fg-2">
            <input
                type="number"
                :value="costData.quantity === 0 ? '' : costData.quantity"
                @change="(e) => updateCostQuantity(e.target.value)"
                class="form-control"
                placeholder="Enter Qty"
            />
        </div>
        <div class="col fg-3">
            <Dropdown
                :selected="costData.unit_of_measurement"
                :list="['HRS', 'MEN', 'PCS', 'MT']"
                @sendValue="(value) => updateCostUOM(value)"
            />
        </div>
        <div class="col fg-4">
            <input
                type="number"
                :value="costData.unit_price === 0 ? '' : costData.unit_price"
                @input="(e) => updateCostUnitPrice(e.target.value)"
                class="form-control"
                placeholder="Enter Unit Price"
            />
        </div>
        <div class="col fg-5">
            <input
                type="number"
                :value="costData.GST_percentage"
                @input="(e) => updateCostGST(e.target.value)"
                class="form-control"
                min="0"
                max="100"
                value="0"
            />
        </div>
        <div class="col fg-6 d-flex justify-content-end align-items-center">
            <div class="i-arrow-right"></div>
        </div>
        <div class="col fg-7">
            <Dropdown
                :selected="costData.currency"
                :list="['USD', 'AUD']"
                @sendValue="(value) => updateCostCurrency(value)"
            />
        </div>
        <div class="col fg-8 d-flex justify-content-end align-items-center">
            <span>{{ costData.vat_amount }}</span>
        </div>
        <div class="col fg-8 d-flex justify-content-end align-items-center">
            <span>{{ costData.sub_total }}</span>
        </div>
        <div class="col fg-8 d-flex justify-content-end align-items-center">
            <span>{{ costData.total }}</span>
        </div>
        <div class="col fg-11">
            <Dropdown
                input="Select an Option"
                :selected="costData.charge_to"
                :list="['MITO', 'Customer']"
                @sendValue="(value) => updateCostChargeTo(value)"
            />
        </div>
        <div class="col fg-12">
            <div class="minus bg-body-secondary" @click="minus">
                <div class="i-minus"></div>
            </div>
        </div>
    </div>
</template>

<script>
import Dropdown from "./Dropdown.vue";
export default {
    name: "cost-table",
    data() {
        return {
            contohList: ["satu", "dua", "tiga", "empat"],
        };
    },
    components: { Dropdown },
    props: {
        index: Number,
        type: String
    },
    computed: {
        costData() {
            return this.$store.getters.getCostData(this.$props.index);
        },
    },
    methods: {
        minus() {
            this.$store.commit("deleteCostList", this.$props.index);
        },
        updateCostDescription(data) {
            this.$store.commit("updateCostDescription", { i: this.$props.index, data })
        },
        updateCostQuantity(data) {
            this.$store.commit("updateCostQuantity", { i: this.$props.index, data })
        },
        updateCostUOM(data) {
            this.$store.commit("updateCostUOM", { i: this.$props.index, data })
        },
        updateCostUnitPrice(data) {
            this.$store.commit("updateCostUnitPrice", { i: this.$props.index, data })
        },
        updateCostGST(data) {
            this.$store.commit("updateCostGST", { i: this.$props.index, data })
        },
        updateCostCurrency(data) {
            this.$store.commit("updateCostCurrency", { i: this.$props.index, data })
        },
        updateCostChargeTo(data) {
            this.$store.commit("updateCostChargeTo", { i: this.$props.index, data })
        },
    },
};
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
</style>
