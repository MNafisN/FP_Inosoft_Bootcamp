<template>
    <div v-if="isShow" class="modal-background">
        <div class="modal-wrapper">
            <div class="d-flex m-1 pointer" @click="showToggle">
                <p class="mb-0 me-1 text-white">close</p>
                <div class="i-close"></div>
            </div>
            <div class="modal-box">
                <p class="text-center fw-bold">Reason of cancellation</p>
                <label class="fs-7">Canceled by</label>
                <p>User</p>
                <label class="fs-7">Description</label>
                <textarea class="w-100 border rounded p-2" rows="5" :value="termination?.termination_reason" @change="e=>updateDescription(e.target.value)"></textarea>
                <label>Attachment</label>
                <AttachmentFile id-name="attachmentTerminate" :files="termination?.attachment" @upload="addAttachment" @delete-by-index="deleteAttachment" />
                <br>
                <br>
                <div class="d-flex justify-content-end align-items-center">
                    <span class="pointer" @click="showToggle">Cancle</span>
                    <button class="bg-primary-custom py-2 my-2 w-180px rounded d-flex justify-content-center align-items-center border-0 text-white fw-medium submit ms-5" @click="submit">
                        Submit
                    </button>
                </div>
            </div>
        </div>
    </div>
    <Title></Title>
    <div class="bg-white w-100 rounded-top shadow p-3">
        <div class="d-flex justify-content-between">
            <router-link to="/app" class="text-decoration-none text-black">
                <div class="d-flex align-items-center gap-1 pointer">
                    <div class="i-back"></div>
                    <span>Back</span>
                </div>
            </router-link>
            <div v-if="instructionStatus !== 'Completed'" class="d-flex gap-3 pointer">
                <span class="d-flex align-items-center gap-1" @click="showToggle">
                    <div class="i-terminate"></div>
                    <span> Terminate</span>
                </span>
                <router-link to="/app/edit-instruction" class="text-black text-decoration-none">
                    <span class="d-flex align-items-center gap-1">
                        <div class="i-modify"></div>
                        <span>Modify</span>
                    </span>
                </router-link>
            </div>
        </div>
        <br />
        <InstructionDetail type="detail" />
        <br />
        <CostDetail type="detail" />
        <br />
        <AttachmentAndNotes type="detail" />
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
import AttachmentFile from "../components/Instruction/AttachmentFile.vue";
export default {
    name: "DetailInstruction",
    data() {
        return {
            isShow: false
        }
    },
    components: { Title, InstructionDetail, CostDetail, AttachmentAndNotes, VendorInvoice, InternalOnly, AttachmentFile },
    computed: {
        instructionStatus() {
            return this.$store.getters.getStatus
        },
        termination() {
            return this.$store.getters.gettermination
        }
    },
    methods: {
        showToggle() {
            this.isShow === false ? this.isShow = true : this.isShow = false
        },
        submit() {
            this.$store.dispatch('terminate')
            this.isShow = false
        },
        addAttachment(file) {
            this.$store.commit('addAttachmentTerminate', file)
        },
        deleteAttachment(index) {
            this.$store.commit('deleteAttachmentTerminate', index)
        },
        updateDescription(text) {
            this.$store.commit('updateDescriptionTermination', text)
        }
    },
    mounted() {
        this.$store.dispatch('detailInstruction', this.$route.params.id)
        this.$store.dispatch('getDataInternalOnly', this.$route.params.id)
    }
};
</script>
