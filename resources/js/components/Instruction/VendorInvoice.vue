<template>
    <div class="d-flex justify-content-between">
        <span class="fw-bold">Vendor Invoice</span>
        <button class="btn btn-secondary">
            <div class="d-flex align-items-center gap-1">
                <div class="i-plus"></div>
                <span>Add Vendor Invoice</span>
            </div>
        </button>
    </div>
    <br>
    <div class="p-2">
        <div class="row bg-secondary text-white">
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
        <VendorInvoiceList v-for="invoice in invoiceList" :invoice="invoice" />
        <div class="row justify-content-center gap-4 p-2 border">
            <p class="width m-0 p-0">Click the button if all vendor invoices have been received</p>
            <button class="btn btn-secondary width">All Received</button>
        </div>
    </div>
</template>

<script>
import VendorInvoiceList from './VendorInvoiceList.vue';
export default {
    name: 'vendor-invoice',
    components: { VendorInvoiceList },
    computed: {
        invoiceList() {
            return this.$store.getters.getVendorInvoiceData
        },
    },
}
</script>

<style scoped>
.width {
    width: 200px;
    max-width: 200px;
}
</style>