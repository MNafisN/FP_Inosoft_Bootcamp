<template>
    <div class="px-2">
        <div v-if="!oneOnly" v-for="(file, index) in files" class="row border-bottom py-1">
            <div class="col-1 d-flex justify-content-center align-items-center">
                <div class="i-attachment pointer"></div>
            </div>
            <div class="col">
                <p class="mb-0 file-name">{{ file.name }}</p>
                <p class="mb-0">{{ file.info }}</p>
            </div>
            <div class="col-1 d-flex justify-content-center align-items-center">
                <div v-if="!isDisable" class="i-delete pointer" @click="$emit('deleteByIndex', index)"></div>
            </div>
        </div>
        <div v-else-if="oneFile !== null" class="row border-bottom py-1">
            <div class="col-1 d-flex justify-content-center align-items-center">
                <div class="i-attachment pointer"></div>
            </div>
            <div class="col">
                <p class="mb-0 file-name">{{ oneFile?.name }}</p>
                <p class="mb-0">{{ oneFile?.info }}</p>
            </div>
            <div class="col-1 d-flex justify-content-center align-items-center">
                <div v-if="!isDisable" class="i-delete pointer" @click="deleteOne"></div>
            </div>
        </div>

        <input
            type="file"
            :id="idName"
            class="d-none"
            @change="(e) => upload(e.target.files[0])"
        />
        <label v-if="!isDisable" :for="idName" class="btn btn-secondary my-2 w-180px">
            <div v-if="!isUpload">
                <div class="i-plus d-inline-block me-1"></div>
                <span> Add Attachment</span>
            </div>
            <div
                v-else
                class="d-flex align-items-center gap-2 justify-content-center"
            >
                <div class="loader d-inline-block"></div>
                <span class="fw-semibold">Uploading...</span>
            </div>
        </label>
    </div>
</template>

<script>
import moment from 'moment'
export default {
    name: "attachment-file",
    data() {
        return {
            isUpload: false,
            disabled: false
        }
    },
    emits: ['upload', 'deleteByIndex', 'deleteOne'],
    props: {
        files: Array,
        to: String,
        oneOnly: Boolean,
        oneFile: Object,
        idName: String,
        isDisable: Boolean
    },
    methods: {
        upload(file) {
            const fileInfo = {
                name: file.name,
                info: `by User on ${moment().format('DD/MM/YY hh:mm A')}`,
                link: "test link"
            }
            this.isUpload = true
            if(this.oneOnly) {
                setTimeout(()=>{
                    this.$emit('upload', fileInfo)
                    this.isUpload = false
                    this.disabled = true
                },2000)
            } else {
                setTimeout(()=>{
                    this.isUpload = false
                    this.$emit('upload', fileInfo)
                },2000)
            }
        },
        deleteOne() {
            this.$emit('deleteOne')
            this.disabled = false
        }
    },
};
</script>

<style scoped>
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