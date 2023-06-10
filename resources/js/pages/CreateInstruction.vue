<template>
    <Title></Title>
    <div class="bg-white w-100 rounded shadow p-3">
        <InstructionCreate></InstructionCreate>
        <CostDetailCreate></CostDetailCreate>
    </div>
</template>

<script>
import Title from '../components/Title.vue';
import InstructionCreate from '../components/Instruction-Create.vue';
import CostDetailCreate from '../components/CostDetail-Create.vue';
export default {
    name: 'CreateInstruction',
    components: { Title, InstructionCreate, CostDetailCreate }
}
</script>