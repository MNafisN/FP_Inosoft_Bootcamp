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
                    :disabled="isDisable"
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
    methods: {
        addAttachment(file) {
            console.log(file);
            this.$store.commit("addAttachment", file);
        },
        deleteAttachment(index) {
            this.$store.dispatch('deleteAttachmentInstruction', index)
        }
    },
    computed: {
        attachmentList() {
            return this.$store.getters.getAttachmentList;
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
