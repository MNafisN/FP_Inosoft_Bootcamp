<template>
    <CreateButton class="mb-3" />
    <DataTable class="table table-hover display" :options="options">
        <thead>
            <tr class="table-secondary">
                <th>Instruction ID</th>
                <th>Link To</th>
                <th class="text-center">Instuction Type</th>
                <th>Assigned Vendor</th>
                <th>Issued Date</th>
                <th>Attention Of</th>
                <th>Quotation No.</th>
                <th>Customer PO</th>
                <th class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(item, index) in filteredData" :key="index">
                <td scope="row">{{ item.instruction_id }}</td>
                <td>{{ item.invoice_to }}</td>
                <td class="text-center">
                    <Type :type="item.instruction_type" />
                </td>
                <td>{{ item.assigned_vendor }}</td>
                <td>{{ item.date_issued }}</td>
                <td>{{ item.attention_of }}</td>
                <td>{{ item.quotation_number }}</td>
                <td>{{ item.customer_PO_number }}</td>
                <td><Pills :type="item.instruction_status" /></td>
            </tr>
        </tbody>
    </DataTable>
</template>

<script>
import DataTable from "datatables.net-vue3";
import DataTablesCore from "datatables.net-bs5";

import CreateButton from "./CreateButton.vue";
import Type from "./Table/Type.vue";
import Pills from "./Table/Pills.vue";

import dataMock from "../../data";

DataTable.use(DataTablesCore);

const columns = [
    { data: "instruction_id", title: "Instruction ID" },
    { data: "invoice_to", title: "Link To" },
    { data: "instruction_type", title: "Instruction Type", components: Type },
    { data: "assigned_vendor", title: "Assigned Vendor" },
    { data: "date_issued", title: "Issued date" },
    { data: "attention_of", title: "Attention Of" },
    { data: "quotation_number", title: "Quotation No." },
    { data: "customer_PO_number", title: "Customer PO" },
    { data: "instruction_status", title: "Status" },
];

const options = {
    // searching: false,
    // paging: false,
};

export default {
    components: {
        DataTable,
        CreateButton,
        Type,
        Pills,
    },
    data() {
        return {
            data: dataMock,
            columns: columns,
            options: options,
        };
    },
    computed: {
        filteredData() {
            return this.data.filter((item) => {
                const instructionStatus = item.instruction_status;
                return (
                    instructionStatus === "Draft" ||
                    instructionStatus === "In-Progress"
                );
            });
        },
    },
};
</script>

<style>
@import "bootstrap";
@import "datatables.net-bs5";
</style>
