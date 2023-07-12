<template>
    <Button :icon="exportIcon" @click="downloadFile()">Export</Button>
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
    methods:{
        async downloadFile(item) {
            const url = `http://127.0.0.1:8000/api/instruction/exportExcel`;

            try {
                const link = document.createElement("a");
                link.href = url;
                link.setAttribute("download", "invoices.xlsx");
                document.body.appendChild(link);
                link.click();
                link.remove();
            } catch (error) {
                // Handle the error
                console.error(
                    "An error occurred while downloading the file:",
                    error
                );
            }
        },
    }
};
</script>
