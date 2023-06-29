<template>
    <div>
        <div class="row">
            <div class="col-2">
                <Dropdown
                    :selected="instructionDetail.instruction_type"
                    :list="['Logistic Instruction', 'Service Intruction']"
                />
            </div>
            <div class="col-8"></div>
            <div class="col-2 d-flex justify-content-end">
                <div class="rounded-pill bg-info-subtle w-50 h-fit">
                    <p class="mx-auto my-0 text-center">Draft</p>
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
                    :list="contohList"
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
                />
            </div>
            <div class="col">
                <label for="quotation-no">Quotation No.</label>
                <input
                    id="quotation-no"
                    type="text"
                    class="form-control"
                    placeholder="Enter Quotation"
                    :value="instructionDetail.quotation_number === 0 ? '' : instructionDetail.quotation_number"
                    required
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
                />
            </div>
            <div class="col">
                <label for="customer-contract">Customer Contract</label>
                <Dropdown
                    input="Select Customer"
                    :searchable="true"
                    :selected="instructionDetail.customer_contact"
                    :list="contohList"
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
                    :list="contohList"
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
    computed: {
        instructionDetail() {
            return this.$store.getters.getInstructionDetail;
        },
    },
};
</script>
