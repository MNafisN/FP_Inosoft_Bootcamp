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
                <input
                    type="file"
                    id="attachment"
                    class="d-none"
                    @change="(e) => upload(e.target.files[0])"
                />
                <label for="attachment" class="btn btn-secondary my-2 w-180px">
                    <div v-if="!isUpload">
                        <div class="i-plus d-inline-block me-1"></div>
                        <span> Add Attachment</span>
                    </div>
                    <div v-else class="d-flex align-items-center gap-2 justify-content-center">
                        <div class="loader d-inline-block"></div>
                        <span class="fw-semibold">Uploading...</span>
                    </div>
                </label>
            </div>
            <div class="col-7">
                <textarea
                    rows="5"
                    class="w-100 form-control bg-secondary-subtle border-secondary"
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
            isUpload: false
        }
    },
    components: { AttachmentFile },
    methods: {
        upload(file) {
            this.isUpload = true
            setTimeout(()=>{
                this.$store.commit("addAttachment", {
                    name: file.name,
                    info: "test",
                    link: "test",
                })
                this.isUpload = false
            }, 2000)
        },
    },
    computed: {
        attachmentList() {
            return this.$store.getters.getAttachmentList;
        },
    },
};
</script>

<style scoped>
.w-180px {
    width: 180px;
}
.file-name {
    font-size: 18px;
    color: blueviolet;
}

.loader {
  border: 4px solid #ffffffc7;
  border-left-color: transparent;
  width: 25px;
  height: 25px;
  border-radius: 50%;
  animation: spin89345 1s linear infinite;
}

@keyframes spin89345 {
  0% {
    transform: rotate(0deg);
  }

  100% {
    transform: rotate(360deg);
  }
}
</style>
