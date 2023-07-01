<template>
    <div
        class="bg-white w-100 rounded-top shadow p-3 d-flex justify-content-end align-items-center gap-4"
    >
        <span class="fs-7">Cancle</span>
        <button class="btn border fw-medium fs-7 draft">Save as Draft</button>
        <button class="btn btn-secondary fw-medium fs-7 submit">Submit</button>
    </div>
</template>

<style scoped>
.fs-7{
    font-size: 0.8rem;
}
.draft{
    width: 150px;
    height: 40px;
}
.submit{
    width: 180px;
    height: 40px;
}
</style>