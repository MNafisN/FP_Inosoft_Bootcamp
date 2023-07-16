<template>
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
            <div class="bg-secondary bulet d-flex justify-content-center align-items-center text-white">
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
            <div v-if="!isDisable" class="i-delete pointer" @click="deleteInvoice"></div>
            <div v-if="!isDisable" class="i-modify pointer" @click="$emit('modify')"></div>
        </div>
    </div>
</template>

<script>
export default {
    name: "vendor-invoice-list",
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
        deleteInvoice() {
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