<template>
    <div class="modal-background d-flex justify-content-center align-items-center">
        <div class="modal-wrapper">
            <div class="d-flex m-1 pointer" @click="$emit('showToggle')">
                <p class="mb-0 me-1 text-white">close</p>
                <div class="i-close"></div>
            </div>
            <div class="w-100 p-4 pt-5 bg-white rounded">
                <label> Invoice No.</label>
                <input
                    type="text"
                    class="form-control"
                    placeholder="Vendor Invoice No."
                    @change="e=> this.invoice.invoice_no = e.target.value"
                    :value="invoice.invoice_no"
                />
                <br />
                <label>Invoice Attachment</label>
                <br />
                <AttachmentFile id-name="invoiceAttachment" :one-only="true" :one-file="attachmentFile" @upload="addInvoice" @delete-one="deleteInvoice" />
                <br />
                <label>Supporting Document</label>
                <br />
                <AttachmentFile id-name="supportingDocument" :files="supportingDocument" @upload="addDocument" @deleteByIndex="deleteDocument" />
                <div class="d-flex justify-content-end align-items-center">
                    <span class="pointer" @click="$emit('showToggle')">Cancle</span>
                    <button class="btn btn-secondary fw-medium submit ms-5" @click="submit">
                        Submit
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import AttachmentFile from './AttachmentFile.vue';
export default {
    name: "add-vendor-invoice",
    data() {
        return {
            isUpload: false,
            invoice: {
                invoice_no: "",
                invoice_attachment: null,
                supporting_document: []
            },
        };
    },
    props: {
        indexEdit: Number
    },
    emits: ['showToggle'],
    components: { AttachmentFile },
    computed: {
        attachmentFile() {
            return this.invoice.invoice_attachment
        },
        supportingDocument() {
            return this.invoice.supporting_document
        }
    },
    methods: {
        addInvoice(file) {
            this.invoice.invoice_attachment = file
        },
        deleteInvoice() {
            this.invoice.invoice_attachment = null
        },
        addDocument(file) {
            this.invoice.supporting_document.push(file)
        },
        deleteDocument(index) {
            this.invoice.supporting_document.splice(index, 1)
        },
        submit() {
            if(this.indexEdit === -1){
                this.$store.commit('addInvoices', this.invoice)
                this.$emit('showToggle')
            } else {
                this.$store.commit('updateInvoice', {invoice: this.invoice, index: this.indexEdit})
                this.$emit('showToggle')
            }
        }
    },
    mounted() {
        if(this.indexEdit !== -1){
            this.invoice = this.$store.getters.getVendorInvoice(this.indexEdit)
        }
    }
};
</script>