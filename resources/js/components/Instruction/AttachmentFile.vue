<template>
    <div class="px-2">
        <div
            v-if="!oneOnly"
            v-for="(file, index) in files"
            class="row border-bottom py-1"
        >
            <div class="col-1 d-flex justify-content-center align-items-center">
                <div
                    class="i-attachment pointer"
                    @click="download(file.download, file.name)"
                ></div>
            </div>
            <div class="col">
                <p class="mb-0 file-name">{{ file.name }}</p>
                <p class="mb-0">{{ file.info }}</p>
            </div>
            <div class="col-1 d-flex justify-content-center align-items-center">
                <div
                    v-if="!isDisable"
                    class="i-delete pointer"
                    @click="$emit('deleteByIndex', index, file.download)"
                ></div>
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
                <div
                    v-if="!isDisable"
                    class="i-delete pointer"
                    @click="deleteOne"
                ></div>
            </div>
        </div>

        <input
            type="file"
            :id="idName"
            class="d-none"
            @change="(e) => upload(e.target.files[0])"
        />
        <label
            v-if="!isDisable && !uploadDisabled"
            :for="idName"
            class="btn btn-secondary my-2 w-180px"
        >
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
</template>

<script>
import axios from "axios";
import moment from "moment";
export default {
    name: "attachment-file",
    data() {
        return {
            isUpload: false,
            uploadDisabled: false,
        };
    },
    emits: ["upload", "deleteByIndex", "deleteOne"],
    props: {
        files: Array,
        to: String,
        oneOnly: Boolean,
        oneFile: Object,
        idName: String,
        isDisable: Boolean,
    },
    methods: {
        upload(file) {
            this.isUpload = true;
            const formData = new FormData();
            formData.append("attachment", file);
            axios
                .post("/api/instruction/uploadFile", formData)
                .then((json) => {
                    const fileInfo = {
                        name: file.name,
                        info: `by ${json.data?.file.posted_by} on ${moment().format("DD/MM/YY hh:mm A")}`,
                        download: json.data?.file.file_name,
                    };
                    this.$emit("upload", fileInfo);
                    this.isUpload = false;
                    if(this.oneOnly) this.uploadDisabled = true
                })
                .catch((err) => {
                    console.log(err);
                    this.isUpload = false;
                });
        },
        download(download, fileName) {
            axios({
                url: `/api/instruction/downloadFile/${encodeURI(download)}`,
                method: "GET",
                responseType: "blob",
            }).then((response) => {
                var fileURL = window.URL.createObjectURL( new Blob([response.data]) );
                var fileLink = document.createElement("a");

                fileLink.href = fileURL;
                fileLink.setAttribute("download", fileName);
                document.body.appendChild(fileLink);

                fileLink.click();
            });
        },
        deleteOne() {
            this.$emit("deleteOne");
            this.disabled = false;
        },
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
