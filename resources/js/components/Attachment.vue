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
                <AttachmentFile v-for="file in attachmentList" :file="file" />
                <input type="file" id="attachment" class="d-none" @change="e => upload(e.target.files[0])">
                <label for="attachment" class="btn btn-secondary my-2 w-180px"><div class="i-plus d-inline-block me-1"></div>Add Attachment</label>
            </div>
            <div class="col-7">
                <textarea rows="5" class="w-100 form-control bg-secondary-subtle border-secondary"></textarea>
            </div>
        </div>
    </div>
</template>

<script>
import AttachmentFile from './AttachmentFile.vue';
export default {
    name: 'attachment',
    components: { AttachmentFile },
    methods: {
        upload(file) {
            this.$store.dispatch('uploadAttachment', {
                name: file.name,
                info: 'test',
                link: 'test'
            })
        }
    },
    computed: {
        attachmentList() {
            return this.$store.getters.getAttachmentList
        }
    }
}
</script>

<style scoped>
    .w-180px{
        width: 180px;
    }
    .file-name{
        font-size: 18px;
        color: blueviolet;
    }
</style>