<template>
    <div
        class="w-100 p-2 badge rounded-pill fw-normal position-relative"
        :class="type"
    >
        {{ type }}
        <div
            v-if="type === 'Cancelled'"
            class="position-absolute top-50 translate-middle-y bg-primary rounded-circle clicked-icon"
            role="button"
            data-bs-toggle="modal"
            data-bs-target="#exampleModal"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                width="16"
                height="16"
                fill="currentColor"
                class="bi bi-info-lg"
                viewBox="0 0 16 16"
            >
                <path
                    d="m9.708 6.075-3.024.379-.108.502.595.108c.387.093.464.232.38.619l-.975 4.577c-.255 1.183.14 1.74 1.067 1.74.72 0 1.554-.332 1.933-.789l.116-.549c-.263.232-.65.325-.905.325-.363 0-.494-.255-.402-.704l1.323-6.208Zm.091-2.755a1.32 1.32 0 1 1-2.64 0 1.32 1.32 0 0 1 2.64 0Z"
                />
            </svg>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        type: {
            type: String,
            required: true,
        },
    },
};
</script>

<style scoped>
.Draft {
    background-color: #f5f6f8;
    color: black;
    outline: 1px solid #d4d4d4;
}

.Completed {
    background-color: #00c060;
    color: white;
}

.In-Progress {
    background-color: #e2ebf9;
    color: #7087a9;
    outline: 1px solid #c2c9d4;
}

.Cancelled {
    background-color: #b9c0c7;
    color: white;
}
.clicked-icon {
    right: 4px;
    padding: 2px;
}
</style>
