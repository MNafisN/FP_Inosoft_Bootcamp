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
                                type="button"
                                class="list-group-item list-group-item-action"
                                aria-current="true"
                            >
                                {{ termination.attachment }}
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
            termination: "getTermination",
        }),
    },
};
</script>

<style></style>
