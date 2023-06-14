<template>
    <button
        type="button"
        class="btn d-flex justify-content-center align-items-center"
        :class="type"
    >
        <component
            :is="icon"
            class="icon"
            :class="{ 'me-2': !!this.$slots.default }"
        />
        <slot />
    </button>
</template>

<script>
export default {
    props: {
        type: {
            type: String,
            default: "outlined",
        },
        icon: {
            type: [String, Object],
            default: "",
        },
    },
    methods: {
        log: function (e) {
            console.log(this.$slots.default);
        },
    },
};
</script>

<style scoped>
.primary {
    background: #00bfbf !important;
    color: white !important;
}

.primary .icon {
    color: white;
}

.outlined {
    border: 1px solid #d3d6d8;
    font-weight: 500;
}

.outlined:hover {
    border: 1px solid #d3d6d8;
    background: #f0f0f0;
}

.outlined .icon {
    color: #00bfbf;
}
</style>
