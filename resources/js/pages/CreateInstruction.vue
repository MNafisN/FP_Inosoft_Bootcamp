<template>
    <Title></Title>
    <div class="bg-white w-100 rounded shadow p-3">
        <InstructionDetail />
        <br />
        <CostDetail />
        <br />
        <AttachmentAndNotes />
    </div>
    <br />
    <LinkTo />
    <br />
    <SubmitInstruction />
</template>

<script>
import Title from "../components/Title.vue";
import InstructionDetail from "../components/Instruction/InstructionDetail.vue";
import CostDetail from "../components/Instruction/CostDetail.vue";
import AttachmentAndNotes from "../components/Instruction/AttachmentAndNotes.vue";
import SubmitInstruction from "../components/Instruction/SubmitInstruction.vue";
import LinkTo from "../components/Instruction/LinkTo.vue";
export default {
    name: "CreateInstruction",
    components: {
        Title,
        InstructionDetail,
        CostDetail,
        AttachmentAndNotes,
        SubmitInstruction,
        LinkTo
    },
    mounted() {
        this.$store.dispatch('getFormData')
    }
};
</script>
