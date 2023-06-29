<template>
    <Title></Title>
    <div class="bg-white w-100 rounded shadow p-3">
        <div class="d-flex justify-content-between">
            <p>Back</p>
            <div>
                <span class="me-5">Terminate</span>
                <span>Modify</span>
            </div>
        </div>
        <InstructionDetail></InstructionDetail>
        <CostDetailCreate></CostDetailCreate>
    </div>
</template>

<script>
    import Title from '../components/Title.vue';
    import InstructionDetail from '../components/Instruction-Detail.vue';
    import CostDetailCreate from '../components/CostDetail-Create.vue';
    export default {
        name: 'DetailInstruction',
        components: { Title, InstructionDetail, CostDetailCreate }
    }
</script>