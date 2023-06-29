<template>
    <div class="row border-bottom py-1">
        <div class="col-1 d-flex justify-content-center align-items-center">
            <div class="i-attachment"></div>
        </div>
        <div class="col">
            <p class="mb-0 file-name">{{ file.name }}</p>
            <p class="mb-0">{{ file.info }}</p>
        </div>
        <div class="col-1 d-flex justify-content-center align-items-center">
            <div class="i-delete"></div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'attachment-file',
    props: {
        file: Object
    }
}
</script>