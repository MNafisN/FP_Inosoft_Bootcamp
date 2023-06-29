<template>
    <Button :icon="exportIcon">Export</Button>
</template>
<script>
import { shallowRef } from "vue";

import Button from "./Button.vue";

import ExportIcon from "./Icon/ExportIcon.vue";

export default {
    name: "ExportButton",
    components: { Button, ExportIcon },
    data() {
        return {
            exportIcon: shallowRef(ExportIcon),
        };
    },
};
</script>
