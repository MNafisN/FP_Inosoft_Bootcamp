<template>
    <button
        type="button"
        class="dropdown-toggle"
        data-bs-toggle="dropdown"
        aria-expanded="false"
    >
        <div class="badge rounded-circle number">
            <slot />
        </div>
    </button>
    <ul class="dropdown-menu">
        <li><a class="dropdown-item" href="#">Action</a></li>
        <li><a class="dropdown-item" href="#">Another action</a></li>
        <li><a class="dropdown-item" href="#">Something else here</a></li>
    </ul>
</template>

<script>
export default {};
</script>

<style scoped>
.number {
    background: #00bfbf;
    padding: 8px 10px;
}
</style>
