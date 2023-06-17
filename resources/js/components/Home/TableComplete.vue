<template>
    <table class="table table-hover mt-4">
        <thead>
            <tr class="table-secondary">
                <th scope="col">Instruction ID</th>
                <th scope="col">Link To</th>
                <th scope="col">Instuction Type</th>
                <th scope="col">Assigned Vendor</th>
                <th scope="col">Issued Date</th>
                <th scope="col">Attention Of</th>
                <th scope="col">Quotation No.</th>
                <th scope="col">Invoice</th>
                <th scope="col">Customer PO</th>
                <th scope="col">Status</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th scope="row">1</th>
                <td>Mark</td>
                <td><Type :type="'si'" /></td>
                <td>Otto</td>
                <td>Mark</td>
                <td>Otto</td>
                <td>Mark</td>
                <td><Invoice>2</Invoice></td>
                <td>Otto</td>
                <td><Pills :type="'Completed'" /></td>
            </tr>
            <tr>
                <th scope="row">1</th>
                <td>Mark</td>
                <td><Type :type="'si'" /></td>
                <td>Otto</td>
                <td>Mark</td>
                <td>Otto</td>
                <td>Mark</td>
                <td><Invoice>10</Invoice></td>
                <td>Otto</td>
                <td><Pills :type="'Cancelled'" /></td>
            </tr>
            <tr>
                <th scope="row">1</th>
                <td>Mark</td>
                <td><Type :type="'si'" /></td>
                <td>Otto</td>
                <td>Mark</td>
                <td>Otto</td>
                <td>Mark</td>
                <td><Invoice>1</Invoice></td>
                <td>Otto</td>
                <td><Pills :type="'Cancelled'" /></td>
            </tr>
            <tr>
                <th scope="row">1</th>
                <td>Mark</td>
                <td><Type :type="'si'" /></td>
                <td>Otto</td>
                <td>Mark</td>
                <td>Otto</td>
                <td>Mark</td>
                <td><Invoice>0</Invoice></td>
                <td>Otto</td>
                <td><Pills :type="'Completed'" /></td>
            </tr>
        </tbody>
    </table>
</template>

<script>
import Invoice from "./Table/Invoice.vue";
import Type from "./Table/Type.vue";
import Pills from "./Table/Pills.vue";
export default {
    components: {
        Invoice,
        Type,
        Pills,
    },
};
</script>

<style></style>
