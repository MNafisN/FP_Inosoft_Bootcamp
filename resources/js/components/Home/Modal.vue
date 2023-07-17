<template>
    <div
        class="modal modal-lg fade"
        id="exampleModal"
        tabindex="-1"
        aria-labelledby="exampleModalLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">
                        Reason of Rejection
                    </h1>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Cancelled by</label>
                        <input
                            type="text"
                            class="form-control"
                            v-model="termination.canceled_by"
                            disabled
                        />
                    </div>
                    <div class="mb-3">
                        <label
                            for="exampleFormControlTextarea1"
                            class="form-label"
                            >Description</label
                        >
                        <textarea
                            class="form-control"
                            id="exampleFormControlTextarea1"
                            rows="3"
                            v-model="termination.termination_reason"
                            disabled
                        ></textarea>
                    </div>
                    <div class="mb-3">
                        <label
                            for="exampleFormControlTextarea1"
                            class="form-label"
                            >Attachment</label
                        >
                        <div class="list-group">
                            <button
                                v-for="(item, index) in termination.attachment"
                                :key="index"
                                type="button"
                                class="list-group-item list-group-item-action"
                                aria-current="true"
                                @click="downloadFile(item.download)"
                            >
                                {{ item.name }}
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal"
                    >
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters } from "vuex";

export default {
    computed: {
        ...mapGetters({
            termination: "getModalTermination",
        }),
    },
    methods: {
        async downloadFile(item) {
            const url = `http://127.0.0.1:8000/api/instruction/downloadFile/${item}`;

            try {
                axios({
                    url: url,
                    method: "GET",
                    responseType: "blob",
                }).then((response) => {
                    const blob = new Blob([response.data]);
                    const downloadUrl = URL.createObjectURL(blob);
                    const link = document.createElement("a");
                    link.href = downloadUrl;
                    link.setAttribute("download", item);
                    document.body.appendChild(link);
                    link.click();
                    link.remove();
                    URL.revokeObjectURL(downloadUrl);
                });
            } catch (error) {
                // Handle the error
                console.error(
                    "An error occurred while downloading the file:",
                    error
                );
            }
        },
    },
};
</script>

<style></style>
