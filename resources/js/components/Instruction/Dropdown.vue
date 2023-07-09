<template>
    <div class="custom-dropdown position-relative">
        <input
            type="text"
            class="form-control pointer"
            :placeholder="input"
            :value="selected"
            readonly
            @click="dropdown"
        />
        <div class="i-dropdown"></div>
        <div :class="`position-absolute z-2 w-100 border border-2 rounded bg-white ${visible} ${upper ? 'upper' : null}`">
            <div v-if="searchable" class="border-bottom p-2 d-flex align-items-center gap-1">
                <div class="i-search"></div>
                <input
                    type="text"
                    class="input"
                    :value="search"
                    @input="(event) => (search = event.target.value)"
                />
            </div>
            <div v-if="noList" class="w-100">
                <p class="text-center my-3">No Data</p>
            </div>
            <ul>
                <li
                    v-for="(item, index) in list"
                    @click="()=>{selected = item; $emit('sendValue', selected); dropdown()}"
                    :class="hidden(index)"
                >
                    {{ item }}
                </li>
            </ul>
            <div v-if="addNew" class="p-2">
                <button
                    class="invoiceButton btn border w-100"
                    @click="showModal"
                >
                    <span class="fw-bold fs-5 lh-1">+</span> Add New Invoice
                </button>
            </div>
            <p v-if="type === 'vendor-address' && noList" class="ms-2 mb-2">
                Please choose Assigned Vendor to enable adding option
            </p>
        </div>
    </div>
    <div :class="visible + ' window'" @click="dropdown"></div>
    <div :class="modal + ' modal-background'">
        <div class="modal-wrapper">
            <div class="d-flex m-1 pointer" @click="showModal">
                <p class="mb-0 me-1 text-white">close</p>
                <div class="i-close"></div>
            </div>
            <div class="w-100 p-4 bg-white rounded">
                <h5 class="text-center mb-4">Add Invoice Target</h5>
                <label> Invoice To</label>
                <input
                    type="text"
                    class="form-control"
                    placeholder="Invoice To"
                />
                <br />
                <br />
                <br />
                <div class="d-flex justify-content-end align-items-center">
                    <span class="pointer" @click="showModal">Cancle</span>
                    <button class="btn btn-secondary fw-medium submit ms-5">
                        Submit
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "custom-dropdown",
    data() {
        return {
            noList: false,
            search: "",
            visible: "d-none",
            modal: "d-none",
        };
    },
    props: {
        input: String,
        type: String,
        selected: String,
        list: Array,
        searchable: Boolean,
        addNew: Boolean,
        disable: Boolean,
        upper: Boolean
    },
    emits: ['sendValue'],
    methods: {
        hidden(i) {
            return this.$props.list[i]
                .toLowerCase()
                .search(this.$data.search) === -1
                ? "d-none"
                : "active";
        },
        searchList(value) {
            this.$data.search = value;
            console.log(value);
        },
        dropdown() {
            if (!this.$props.disable) {
                this.$data.visible === "d-none"
                    ? (this.$data.visible = "")
                    : (this.$data.visible = "d-none");
            }
        },
        showModal() {
            this.$data.modal === "d-none"
                ? (this.$data.modal = "")
                : (this.$data.modal = "d-none");
        },
    },
};
</script>

<style scoped>
.input {
    width: 100%;
    border: none;
    outline: none;
}
ul {
    margin: 0;
    padding: 0;
    max-height: 300px;
    overflow-y: auto;
}
li {
    list-style: none;
    padding: 0.5rem 1rem;
}
li:hover {
    background-color: #e9baff;
}
.window {
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    position: fixed;
    z-index: 1;
}
.invoiceButton {
    height: 35px;
}
.upper{
    top: 0;
    transform: translateY(-100%);
}
</style>
