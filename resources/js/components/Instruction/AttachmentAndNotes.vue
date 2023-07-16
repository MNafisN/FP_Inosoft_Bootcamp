<template>
    <div>
        <div class="row">
            <div class="col-5">
                <span class="fs-5">Attachment</span>
            </div>
            <div class="col-7">
                <span class="fs-5">Notes</span>
            </div>
        </div>
        <div class="row">
            <div class="col-5">
                <AttachmentFile
                    id-name="attachmentFile"
                    :files="attachmentList"
                    :is-disable="isDisable"
                    @upload="addAttachment"
                    @delete-by-index="deleteAttachment"
                />
            </div>
            <div class="col-7">
                <textarea
                    rows="5"
                    class="w-100 form-control bg-secondary-subtle border-secondary"
                    :value="notes"
                    @change="(e)=>updateNotes(e.target.value)"
                    :disabled="isDisable || type === 'detail'"
                ></textarea>
            </div>
        </div>
    </div>
</template>

<script>
import AttachmentFile from "./AttachmentFile.vue";
export default {
    name: "attachment",
    data() {
        return {
            isUpload: false,
        };
    },
    components: { AttachmentFile },
    props: {
        type: String
    },
    methods: {
        addAttachment(file) {
            if(this.type === "detail") {
                this.$store.dispatch("addAttachmentInDetail", file)
            } else {
                this.$store.commit("addAttachment", file);
            }
        },
        deleteAttachment(index) {
            this.$store.dispatch('deleteAttachmentInstruction', index)
        },
        updateNotes(text) {
            this.$store.commit('updateNotes', text)
        }
    },
    computed: {
        attachmentList() {
            return this.$store.getters.getAttachmentList;
        },
        notes() {
            return this.$store.getters.getNotes
        },
        isDisable() {
            return (
                this.$store.getters.getStatus === "Completed" ||
                this.$store.getters.getStatus === "Canceled"
            );
        },
    },
};
</script>
