<template>
    <div v-if="type === 'detail'" class="border p-2">
        <div class="row">
            <div class="col">
                <span>Type</span>
                <p class="fw-bold">{{ instructionDetail.instruction_type }}</p>
            </div>
            <div class="col">
                <span>LI No</span>
                <p class="fw-bold">{{ instructionDetail.instruction_id }}</p>
            </div>
            <div class="col">
                <span>Transfer No</span>
                <div class="p-2 bg-info-subtle text-center">{{ instructionDetail.transaction_code }}</div>
            </div>
            <div class="col">
                <span>Customer</span>
                <p class="fw-bold">{{ instructionDetail.customer_contact }}</p>
            </div>
            <div class="col">
                <span>Customer PO</span>
                <p class="fw-bold">{{ instructionDetail.cust_po_number }}</p>
            </div>
            <div class="col">
                <span>Status</span>
                <div :class="`${instructionDetail.instruction_status === 'Completed' ? 'text-bg-success' : 'bg-info-subtle'} rounded-pill w-50 h-fit`">
                    <p class="mx-auto my-0 text-center fs-7 py-1">{{ instructionDetail.instruction_status }}</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <span>Attention Of</span>
                <p class="fw-bold">{{ instructionDetail.attention_of }}</p>
            </div>
            <div class="col">
                <span>Assigment Vendor</span>
                <p class="fw-bold">{{ instructionDetail.assigned_vendor }}</p>
            </div>
            <div class="col">
                <span>Vendor Quotation No.</span>
                <p class="fw-bold">{{ instructionDetail.quotation_number }}</p>
            </div>
            <div class="col-6">
                <span>Vendor Address</span>
                <p class="fw-bold">
                    {{ instructionDetail.vendor_address }}
                </p>
            </div>
        </div>
    </div>

    <div v-else>
        <div class="row">
            <div class="col-2">
                <Dropdown
                    :selected="instructionDetail.instruction_type"
                    :list="['Logistic Instruction', 'Service Intruction']"
                    :disable="type === 'edit'"
                    @send-value="updateInstructionType()"
                />
            </div>
            <div class="col-8"></div>
            <div class="col-2 d-flex justify-content-end">
                <div class="rounded-pill bg-info-subtle w-50 h-fit">
                    <p class="mx-auto my-0 text-center">{{ instructionDetail.instruction_status }}</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col"></div>
            <div class="col">
                <label for="assigned-vendor">Assigned Vendor</label>
                <Dropdown
                    input="Enter Vendor"
                    :searchable="true"
                    :selected="instructionDetail.assigned_vendor"
                    :list="vendorName"
                    @send-value="updateAssignedVendor"
                />
            </div>
            <div class="col">
                <label for="attention-of">Attention Of</label>
                <input
                    id="attention-of"
                    type="text"
                    class="form-control"
                    placeholder="Enter Attention Of"
                    :value="instructionDetail.attention_of"
                    required
                    @change="(e)=>updateAttentionOf(e.target.value)"
                />
            </div>
            <div class="col">
                <label for="quotation-no">Quotation No.</label>
                <input
                    id="quotation-no"
                    type="number"
                    class="form-control"
                    placeholder="Enter Quotation"
                    :value="
                        instructionDetail.quotation_number === 0
                            ? ''
                            : instructionDetail.quotation_number
                    "
                    required
                    @change="(e)=>updateQuotationNumber(e.target.value)"
                />
            </div>
            <div class="col border-right-dashed">
                <label for="invoice-to">Invoice to</label>
                <Dropdown
                    input="Select an Option"
                    :searchable="true"
                    :add-new="true"
                    :selected="instructionDetail.invoice_to"
                    :list="['MITO']"
                    @send-value="updateInvoiceTo"
                />
            </div>
            <div class="col">
                <label for="customer-contract">Customer Contract</label>
                <Dropdown
                    input="Select Customer"
                    :searchable="true"
                    :selected="instructionDetail.customer_contact"
                    :list="customer"
                    @send-value="updateCustomerContract"
                />
            </div>
        </div>
        <div class="row">
            <div class="col-2"></div>
            <div class="col-8 border-right-dashed">
                <label for="vendor-address">Vendor Address</label>
                <Dropdown
                    input="Enter Vendor Address"
                    type="vendor-address"
                    :searchable="true"
                    :selected="instructionDetail.vendor_address"
                    :list="vendorAddress"
                    @send-value="updateVendorAddress"
                />
            </div>
            <div class="col-2">
                <label for="costomer-po-no">Customer PO No.</label>
                <input
                    id="customer-po-no"
                    type="text"
                    class="form-control"
                    placeholder="Enter Customer PO"
                    :value="instructionDetail.cust_po_number"
                    @change="(e)=>updatePoNumber(e.target.value)"
                />
            </div>
        </div>
    </div>
</template>

<script>
import Dropdown from "./Dropdown.vue";
export default {
    name: "instruction-create",
    components: { Dropdown },
    data() {
        return {
            contohList: ["satu", "dua", "tiga", "empat"],
        };
    },
    props: {
        type: String,
    },
    computed: {
        instructionDetail() {
            return this.$store.getters.getInstructionDetail;
        },
        FormData() {
            return this.$store.getters.getFormData
        },
        customer() {
            return this.FormData.customers.flatMap((x)=> x.cust_name)
        },
        vendorName() {
            return this.FormData.vendors?.flatMap((x)=> x.vendor_name)
        },
        vendorAddress() {
            const vendor = this.FormData.vendors?.filter((x)=>{ return x.vendor_name === this.instructionDetail.assigned_vendor})
            return vendor[0]?.vendor_address
        },
    },
    methods: {
        updateInstructionType(payload) {
            this.$store.commit('updateInstructionType', payload)
        },
        updateAssignedVendor(payload) {
            this.$store.commit('updateAssignedVendor', payload)
        },
        updateVendorAddress(payload) {
            this.$store.commit('updateVendorAddress', payload)
        },
        updateAttentionOf(payload) {
            this.$store.commit('updateAttentionOf', payload)
        },
        updateQuotationNumber(payload) {
            this.$store.commit('updateQuotationNumber', payload)
        },
        updateInvoiceTo(payload) {
            this.$store.commit('updateInvoiceTo', payload)
        },
        updateCustomerContract(payload) {
            this.$store.commit('updateCustomerContract', payload)
        },
        updatePoNumber(payload) {
            this.$store.commit('updatePoNumber', payload)
        },
    },
    mounted() {
        console.log(this.instructionDetail);
    }
};
</script>
