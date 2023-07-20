<template>
    <Title></Title>
    <div class="bg-white w-100 rounded shadow p-3">
        <InstructionDetail type="edit" />
        <br />
        <CostDetail />
        <br />
        <AttachmentAndNotes />
    </div>
    <br />
    <LinkTo />
    <br />
    <SubmitInstruction type="edit" />
</template>

<script>
import Title from "../components/Title.vue";
import InstructionDetail from "../components/Instruction/InstructionDetail.vue";
import CostDetail from "../components/Instruction/CostDetail.vue";
import AttachmentAndNotes from "../components/Instruction/AttachmentAndNotes.vue";
import LinkTo from "../components/Instruction/LinkTo.vue";
import SubmitInstruction from "../components/Instruction/SubmitInstruction.vue";
export default {
    name: "EditInstruction",
    components: {
        Title,
        InstructionDetail,
        CostDetail,
        AttachmentAndNotes,
        LinkTo,
        SubmitInstruction,
    },
};
</script>
