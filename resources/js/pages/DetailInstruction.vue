<template>
    <Title></Title>
    <div class="bg-white w-100 rounded-top shadow p-3">
        <div class="d-flex justify-content-between">
            <div class="d-flex align-items-center gap-1 pointer">
                <div class="i-back"></div>
                <span>Back</span>
            </div>
            <div class="d-flex gap-3 pointer">
                <span class="d-flex align-items-center gap-1">
                    <div class="i-terminate"></div>
                    <span> Terminate</span>
                </span>
                <span class="d-flex align-items-center gap-1">
                    <div class="i-modify"></div>
                    <span>Modify</span>
                </span>
            </div>
        </div>
        <br />
        <InstructionDetail type="detail" />
        <br />
        <CostDetail type="detail" />
        <br />
        <AttachmentAndNotes />
        <br>
        <VendorInvoice />
        <br>
    </div>
    <InternalOnly />
</template>

<script>
import InstructionDetail from "../components/Instruction/InstructionDetail.vue";
import CostDetail from "../components/Instruction/CostDetail.vue";
import Title from "../components/Title.vue";
import AttachmentAndNotes from "../components/Instruction/AttachmentAndNotes.vue";
import VendorInvoice from "../components/Instruction/VendorInvoice.vue";
import InternalOnly from "../components/Instruction/InternalOnly.vue";
export default {
    name: "DetailInstruction",
    components: { Title, InstructionDetail, CostDetail, AttachmentAndNotes, VendorInvoice, InternalOnly },
};
</script>
