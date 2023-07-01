<template>
    <div class="row border p-2">
        <div class="col">
            <span>{{ invoice.invoice_no }}</span>
        </div>
        <div class="col">
            <div class="d-flex align-items-center gap-1">
                <div class="i-attachment"></div>
                <span>{{ invoice.invoice_attachment.name }}</span>
            </div>
        </div>
        <div class="col d-flex">
            <div class="bg-secondary bulet d-flex justify-content-center align-items-center text-white">
                <span>{{ supportingDocument }}</span>
            </div>
            <div class="dropdown">
                <button class="bulet bg-scondary-suble border-0 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-e></button>
                <ul class="dropdown-menu">
                    <li v-for="data in invoice.supportingDocument" class="dropdown-item">{{ data.name }}</li>
                </ul>
            </div>
        </div>
        <div class="col-1 d-flex align-items-center justify-content-end gap-3">
            <div class="i-delete"></div>
            <div class="i-modify"></div>
        </div>
    </div>
</template>

<script>
export default {
    name: "vendor-invoice-list",
    props: {
        invoice: Object
    },
    computed: {
        supportingDocument() {
            return this.invoice.supporting_document.length
        }
    },
}
</script>

<style scoped>
.bulet{
    width: 25px;
    height: 25px;
    border-radius: 50%;
}
</style>