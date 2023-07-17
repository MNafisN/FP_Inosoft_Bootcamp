<template>
    <button
        type="button"
        class="dropdown-toggle"
        data-bs-toggle="dropdown"
        aria-expanded="false"
    >
        <div class="badge rounded-circle number">
            {{ countInvoice }}
        </div>
    </button>
    <ul class="dropdown-menu">
        <li>
            <div
                class="dropdown-item"
                v-for="(item, index) in invoice"
                :key="index"
                @click="downloadFile(item)"
            >
                {{ item.invoice_attachment.name }}
            </div>
        </li>
    </ul>
</template>

<script>
export default {
    props: {
        invoice: {
            type: Object,
        },
        id: {
            type: String,
        },
    },
    computed: {
        countInvoice() {
            return this.invoice.length;
        },
    },
    methods: {
        async downloadFile(item) {
            const url = `http://127.0.0.1:8000/api/instruction/downloadFile/${item.invoice_attachment.download}`;

            try {
                axios({
                    url: url,
                    method: "GET",
                    responseType: "blob",
                }).then((response) => {
                    const blob = new Blob([response.data]);
                    const downloadUrl = URL.createObjectURL(blob);
                    const link = document.createElement("a");
                    link.href = downloadUrl;
                    link.setAttribute("download", item.invoice_attachment.name);
                    document.body.appendChild(link);
                    link.click();
                    link.remove();
                    URL.revokeObjectURL(downloadUrl);
                });
            } catch (error) {
                // Handle the error
                console.error(
                    "An error occurred while downloading the file:",
                    error
                );
            }
        },
    },
};
</script>

<style scoped>
button {
    border: 0;
    background: none;
}
.number {
    background: #00bfbf;
    padding: 8px 10px;
}
</style>
