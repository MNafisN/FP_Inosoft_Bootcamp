<template>
    <div class="row py-2 border">
        <div class="col fg-1">
            <input
                type="text"
                :value="costData.cost_description"
                @input="(e) => (costData.cost_description = e.target.value)"
                class="form-control"
                placeholder="Enter Description"
            />
        </div>
        <div class="col fg-2">
            <input
                type="number"
                :value="costData.quantity === 0 ? '' : costData.quantity"
                @input="(e) => (costData.quantity = e.target.value)"
                class="form-control"
                placeholder="Enter Qty"
            />
        </div>
        <div class="col fg-3">
            <Dropdown
                :selected="costData.unit_of_measurement"
                :list="['SHP', 'BILL', 'HRS', 'MEN', 'PCS', 'TRIP', 'MT']"
                @sendValue="(value) => (costData.unit_of_measurement = value)"
            />
        </div>
        <div class="col fg-4">
            <input
                type="number"
                :value="costData.unit_price === 0 ? '' : costData.unit_price"
                @input="(e) => (costData.unit_price = e.target.value)"
                class="form-control"
                placeholder="Enter Unit Price"
            />
        </div>
        <div class="col fg-5">
            <input
                type="number"
                :value="costData.GST_percentage"
                @input="(e) => (costData.GST_percentage = e.target.value)"
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
                @sendValue="(value) => (costData.currency = value)"
            />
        </div>
        <div class="col fg-8 d-flex justify-content-end align-items-center">
            <span>{{ vatAmount }}</span>
        </div>
        <div class="col fg-8 d-flex justify-content-end align-items-center">
            <span>{{ subTotal }}</span>
        </div>
        <div class="col fg-8 d-flex justify-content-end align-items-center">
            <span>{{ total }}</span>
        </div>
        <div class="col fg-11">
            <Dropdown
                input="Select an Option"
                :selected="costData.charge_to"
                :list="['MITO', 'Customer']"
                @sendValue="(value) => (costData.charge_to = value)"
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
    },
    updated() {
        this.$store.commit("updateCostList", {
            i: this.$props.index,
            data: this.costData,
        });
    },
    computed: {
        costData() {
            return this.$store.getters.getCostData(this.$props.index);
        },
        vatAmount() {
            return (
                (this.costData.unit_price * this.costData.GST_percentage) / 100
            );
        },
        subTotal() {
            return this.costData.unit_price * this.costData.quantity;
        },
        total() {
            return this.subTotal + this.vatAmount;
        },
    },
    methods: {
        minus() {
            this.$store.commit("deleteCostList", this.$props.index);
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
</style>
