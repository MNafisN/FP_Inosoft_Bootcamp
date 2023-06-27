<template>
    <Title></Title>
    <div class="bg-white w-100 rounded shadow p-3">
        <InstructionCreate></InstructionCreate>
        <br>
        <CostDetailCreate></CostDetailCreate>
        <br>
        <Attachment />
    </div>
    <br>
    <div class="bg-white w-100 rounded shadow p-3">
        <div class="w-25">
            <label for="link_to">Link To</label>
            <Dropdown input="Select Item" :list="['satu', 'dua', 'tiga']" />
        </div>
    </div>
    <br>
    <div class="bg-white w-100 rounded-top shadow p-3 d-flex justify-content-end align-items-center gap-4">
        <span>Cancle</span>
        <button class="btn border">Save as Draft</button>
        <button class="btn btn-secondary">Submit</button>
    </div>
</template>

<script>
import Title from '../components/Title.vue';
import InstructionCreate from '../components/Instruction-Create.vue';
import CostDetailCreate from '../components/CostDetail-Create.vue';
import Attachment from '../components/Attachment.vue';
import Dropdown from '../components/Dropdown.vue';
export default {
    name: 'CreateInstruction',
    components: { Title, InstructionCreate, CostDetailCreate, Attachment, Dropdown }
}
</script>