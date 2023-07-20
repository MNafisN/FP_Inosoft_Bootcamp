<template>
    <div v-if="isShow" class="modal-background">
        <div class="modal-wrapper">
            <div class="d-flex m-1 pointer" @click="showToggle">
                <p class="mb-0 me-1 text-white">close</p>
                <div class="i-close"></div>
            </div>
            <div class="modal-box">
                <br><br>
                <div class="i-warning mx-auto"></div>
                <br>
                <div>
                    <p class="fs-5 mb-2 text-center">Are You to delete this vendor invoice</p>
                    <p class="fs-6 text-center">This action can not be un-done</p>
                </div>
                <br>
                <div class="d-flex justify-content-end align-items-center">
                    <span class="pointer" @click="showToggle">Cancle</span>
                    <button class="bg-primary-custom py-2 my-2 w-180px rounded d-flex justify-content-center align-items-center border-0 text-white fw-medium submit ms-5" @click="deleteInvoice">
                        Confirm
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="row border p-2">
        <div class="col">
            <span>{{ invoice.invoice_number }}</span>
        </div>
        <div class="col">
            <div class="d-flex align-items-center gap-1" @click="download(invoice.invoice_attachment.download, invoice.invoice_attachment.name)">
                <div class="i-attachment"></div>
                <span>{{ invoice.invoice_attachment?.name }}</span>
            </div>
        </div>
        <div class="col d-flex">
            <div class="bg-secondary-custom bulet d-flex justify-content-center align-items-center text-white">
                <span>{{ supportingDocument }}</span>
            </div>
            <div class="dropdown">
                <button class="bulet bg-scondary-suble border-0 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-e></button>
                <ul class="dropdown-menu">
                    <li v-for="data in invoice.invoice_supporting_document" class="dropdown-item" @click="download(data.download, data.name)">{{ data.name }}</li>
                </ul>
            </div>
        </div>
        <div class="col-1 d-flex align-items-center justify-content-end gap-3">
            <div v-if="!isDisable" class="i-delete pointer" @click="showToggle"></div>
            <div v-if="!isDisable" class="i-modify pointer" @click="$emit('modify')"></div>
        </div>
    </div>
</template>

<script>
export default {
    name: "vendor-invoice-list",
    data() {
        return {
            isShow: false
        }
    },
    props: {
        invoice: Object,
        index: Number,
        isDisable: Boolean
    },
    computed: {
        supportingDocument() {
            return this.invoice.invoice_supporting_document.length
        }
    },
    methods: {
        showToggle() {
            this.isShow ? this.isShow = false : this.isShow = true
        },
        deleteInvoice() {
            this.showToggle()
            this.$store.dispatch('deleteInvoice', this.index)
        },
        download(download, fileName) {
            axios({
                url: `/api/instruction/downloadFile/${encodeURI(download)}`,
                method: "GET",
                responseType: "blob",
            }).then((response) => {
                var fileURL = window.URL.createObjectURL( new Blob([response.data]) );
                var fileLink = document.createElement("a");

                fileLink.href = fileURL;
                fileLink.setAttribute("download", fileName);
                document.body.appendChild(fileLink);

                fileLink.click();
            });
        },
    }
}
</script>

<style scoped>
.bulet{
    width: 25px;
    height: 25px;
    border-radius: 50%;
}
</style>