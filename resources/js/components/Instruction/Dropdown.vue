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
            <div v-if="list === undefined || list === []" class="w-100">
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
            <div v-if="validationAddNew" class="p-2">
                <button
                    class="invoiceButton btn border w-100"
                    @click="showModal"
                >
                    <span class="fw-bold fs-5 lh-1">+</span> {{ addNewModal[addNew].button }}
                </button>
            </div>
            <p v-if="addNew === 'vendorAddress' && list === undefined" class="ms-2 mb-2">
                Please choose Assigned Vendor to enable adding option
            </p>
        </div>
    </div>
    <div :class="visible + ' window'" @click="dropdown"></div>
    <div v-if="addNew" :class="modal + ' modal-background'">
        <div class="modal-wrapper">
            <div class="d-flex m-1 pointer" @click="showModal">
                <p class="mb-0 me-1 text-white">close</p>
                <div class="i-close"></div>
            </div>
            <div class="w-100 p-4 bg-white rounded">
                <h5 class="text-center mb-4">{{ addNewModal[addNew].title }}</h5>
                <label>{{ addNewModal[addNew].label }}</label>
                <input
                    type="text"
                    class="form-control"
                    :placeholder="addNewModal[addNew].placeholder"
                    @change="e=>newData = e.target.value"
                />
                <br />
                <br />
                <br />
                <div class="d-flex justify-content-end align-items-center gap-2">
                    <span class="pointer" @click="showModal">Cancle</span>
                    <button @click="()=>{selected = newData; $emit('sendValue', selected); dropdown(); showModal()}" class="bg-primary-custom py-2 my-2 w-180px rounded d-flex justify-content-center border-0 text-white fw-medium">
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
            search: "",
            visible: "d-none",
            modal: "d-none",
            addNewModal: {
                invoice: {
                    button: "Add New Invoice",
                    title: "Add Invoice Target",
                    label: "Invoice To",
                    placeholder: "Invoice To"
                },
                vendorAddress: {
                    button: "Add New Vendor Address",
                    title: "Add Vendor Address",
                    label: "Address",
                    placeholder: "Enter Address"
                }
            },
            newData: ""
        };
    },
    props: {
        input: String,
        selected: String,
        list: Array,
        searchable: Boolean,
        addNew: String,
        disable: Boolean,
        upper: Boolean
    },
    emits: ['sendValue'],
    methods: {
        hidden(i) {
            if(this.list[i].toLowerCase().search(this.search.toLowerCase()) === -1) {
                return "d-none"
            } else {
                return "active"
            }
        },
        searchList(value) {
            this.$data.search = value;
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
    computed: {
        validationAddNew() {
            if(!this.addNew) return false;
            if(this.addNew === 'vendorAddress' && this.list === undefined) return false;
            return true
        }
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
