<template>
    <div class="px-3 py-2 bg-dark">
        <span class="fs-6 fw-bold text-white">For Internal Only</span>
    </div>
    <div class="bg-white w-100 shadow p-3">
        <div class="row">
            <div class="col-5">
                <span>Attachment</span>
            </div>
            <div class="col-7">
                <span>Notes</span>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-5">
                <AttachmentFile v-for="file in attachmentData" :file="file" />
                <input
                    type="file"
                    id="attachmentInternal"
                    class="d-none"
                    @change="e=> upload(e.target.files[0])"
                />
                <label for="attachmentInternal" class="btn btn-secondary my-2 w-180px">
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
                <button class="btn btn-secondary my-2 w-180px">
                    <div class="i-plus d-inline-block me-1"></div>
                    <span> Add Internal Notes</span>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import AttachmentFile from './AttachmentFile.vue'
export default {
    name: 'internal-only',
    data() {
        return {
            isUpload: false
        }
    },
    components: { AttachmentFile },
    computed: {
        attachmentData() {
            return this.$store.getters.getAttachmentInternalList
        }
    },
    methods: {
        upload(file) {
            this.isUpload = true
            setTimeout(()=>{
                this.$store.commit("uploadAttachmentInternal", {
                    name: file.name,
                    info: "test",
                    link: "test",
                })
                this.isUpload = false
            }, 2000)
        },

    }
}
</script>

<style scoped>
.w-180px{
    width: 180px;
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