<template>
    <div class="px-3 py-2 bg-dark">
        <span class="fs-6 fw-bold text-white">For Internal Only</span>
    </div>
    <div class="bg-white w-100 shadow p-3">
        <div class="row">
            <div class="col-5 pb-3 pembatas">
                <span>Attachment</span>
            </div>
            <div class="col-7">
                <span>Notes</span>
            </div>
        </div>
        <div class="row">
            <div class="col-5 pembatas">
                <AttachmentFile id-name="attachmentInternalOnly" :files="attachmentData" @upload="addFile" @delete-by-index="deleteFile" />
            </div>
            <div class="col-7">
                <InternalNotes />
            </div>
        </div>
    </div>
</template>

<script>
import AttachmentFile from './AttachmentFile.vue'
import InternalNotes from './InternalNotes.vue'
export default {
    name: 'internal-only',
    data() {
        return {
            isUpload: false,
        }
    },
    components: { AttachmentFile, InternalNotes },
    computed: {
        attachmentData() {
            return this.$store.getters.getAttachmentInternalOnly
        }
    },
    methods: {
        addFile(file) {
            this.$store.commit('addAttachmentInternalOnly', file)
        },
        deleteFile(index) {
            this.$store.commit('deleteAttachmentInternalOnly', index)
        }
    }
}
</script>

<style scoped>
.pembatas{
    border-right: 1px dashed black;
}
</style>