<template>
        <div v-if="isSubmit" class="modal-background">
        <div class="modal-wrapper">
            <div class="d-flex m-1 pointer" @click="submitToggle">
                <p class="mb-0 me-1 text-white">close</p>
                <div class="i-close"></div>
            </div>
            <div class="modal-box">
                <br><br><br>
                <div>
                    <p class="fs-5 mb-2 text-center">Are you sure all Vendor Invoices have been received?</p>
                    <p class="fs-6 text-center">Once confirmed, Vendor invoice will be closed</p>
                </div>
                <br>
                <div class="d-flex justify-content-end align-items-center">
                    <span class="pointer" @click="submitToggle">Cancle</span>
                    <button class="bg-primary-custom py-2 my-2 w-180px rounded d-flex justify-content-center align-items-center border-0 text-white fw-medium submit ms-5" @click="submit">
                        Confirm
                    </button>
                </div>
            </div>
        </div>
    </div>

    <AddVendorInvoice v-if="isShow" @showToggle="showToggle" :indexEdit="indexEdit" />
    <div v-if="!isDisable" class="d-flex justify-content-between">
        <h5>Vendor Invoice</h5>
        <button class="bg-primary-custom py-2 my-2 w-180px rounded d-flex justify-content-center border-0" @click="showToggle">
            <div class="d-flex align-items-center gap-1">
                <div class="i-plus"></div>
                <span class="text-white fw-semibold">Add Vendor Invoice</span>
            </div>
        </button>
    </div>
    <br>
    <div v-if="invoiceList.length !== 0" class="p-2">
        <div class="row bg-secondary-custom text-white">
            <div class="col">
                <span>Invoice No</span>
            </div>
            <div class="col">
                <span>Invoice Attachment</span>
            </div>
            <div class="col">
                <span>Supporting Document</span>
            </div>
            <div class="col-1"></div>
        </div>
        <VendorInvoiceList v-for="(invoice, index) in invoiceList" :invoice="invoice" :index="index" :is-disable="isDisable" @modify="modify(index)" />
        <div v-if="!isDisable" class="row justify-content-center gap-4 p-2 border">
            <p class="width m-0 p-0">Click the button if all vendor invoices have been received</p>
            <button class="bg-primary-custom rounded border-0 text-white fw-semibold width" @click="submitToggle">All Received</button>
        </div>
    </div>
</template>

<script>
import AddVendorInvoice from './AddVendorInvoice.vue';
import VendorInvoiceList from './VendorInvoiceList.vue';
import AttachmentFile from './AttachmentFile.vue';
export default {
    name: 'vendor-invoice',
    data() {
        return {
            isShow: false,
            indexEdit: -1,
            isSubmit: false
        }
    },
    components: { AddVendorInvoice ,VendorInvoiceList, AttachmentFile },
    computed: {
        invoiceList() {
            return this.$store.getters.getVendorInvoiceAll
        },
        isDisable() {
            return this.$store.getters.getStatus === 'Completed' || this.$store.getters.getStatus === 'Canceled'
        }
    },
    methods: {
        submitToggle() {
            this.isSubmit === false ? this.isSubmit = true : this.isSubmit = false
        },
        showToggle() {
            this.indexEdit = -1
            this.$data.isShow === false ? this.$data.isShow = true : this.$data.isShow = false
        },
        addVendorInvoice() {
            this.$store.dispatch('addVendorInvoice', payload)
        },
        modify(index) {
            this.indexEdit = index
            this.isShow = true
        },
        submit() {
            this.$store.dispatch('isCompleted')
            this.submitToggle()
        },
    }
}
</script>

<style scoped>
.width {
    width: 200px;
    max-width: 200px;
}
</style>