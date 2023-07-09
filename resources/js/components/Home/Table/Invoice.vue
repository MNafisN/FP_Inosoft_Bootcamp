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
            <a
                class="dropdown-item"
                href="#"
                v-for="(item, index) in invoice"
                :key="index"
                >{{ item.invoice_number }}</a
            >
        </li>
    </ul>
</template>

<script>
export default {
    props: {
        invoice: {
            type: Object,
        },
    },
    computed: {
        countInvoice() {
            return this.invoice.length;
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
