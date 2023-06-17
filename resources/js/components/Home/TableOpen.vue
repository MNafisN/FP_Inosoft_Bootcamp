<template>
    <CreateButton class="mb-3" />
    <table class="table table-hover">
        <thead>
            <tr class="table-secondary">
                <th scope="col">Instruction ID</th>
                <th scope="col">Link To</th>
                <th scope="col">Instuction Type</th>
                <th scope="col">Assigned Vendor</th>
                <th scope="col">Issued Date</th>
                <th scope="col">Attention Of</th>
                <th scope="col">Quotation No.</th>
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
                <td>Otto</td>
                <td><Pills :type="'Draft'" /></td>
            </tr>
            <tr>
                <th scope="row">1</th>
                <td>Mark</td>
                <td><Type :type="'si'" /></td>
                <td>Otto</td>
                <td>Mark</td>
                <td>Otto</td>
                <td>Mark</td>
                <td>Otto</td>
                <td><Pills :type="'Draft'" /></td>
            </tr>
            <tr>
                <th scope="row">1</th>
                <td>Mark</td>
                <td><Type :type="'si'" /></td>
                <td>Otto</td>
                <td>Mark</td>
                <td>Otto</td>
                <td>Mark</td>
                <td>Otto</td>
                <td><Pills :type="'In-Progress'" /></td>
            </tr>
            <tr>
                <th scope="row">1</th>
                <td>Mark</td>
                <td><Type :type="'si'" /></td>
                <td>Otto</td>
                <td>Mark</td>
                <td>Otto</td>
                <td>Mark</td>
                <td>Otto</td>
                <td><Pills :type="'In-Progress'" /></td>
            </tr>
        </tbody>
    </table>
</template>

<script>
import CreateButton from "./CreateButton.vue";
import Type from "./Table/Type.vue";
import Pills from "./Table/Pills.vue";
export default {
    components: {
        CreateButton,
        Type,
        Pills,
    },
};
</script>

<style></style>
