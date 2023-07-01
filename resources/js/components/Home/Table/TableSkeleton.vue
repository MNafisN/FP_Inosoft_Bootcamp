<template>
    <table class="table table-bordered mt-3">
        <thead>
            <tr class="table-secondary" style="height: 40px">
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="index in 12" :key="index">
                <td class="loading">
                    <div class="bar"></div>
                </td>
                <td class="loading">
                    <div class="bar"></div>
                </td>
                <td class="loading">
                    <div class="bar"></div>
                </td>
                <td class="loading">
                    <div class="bar"></div>
                </td>
                <td class="loading">
                    <div class="bar"></div>
                </td>
                <td class="loading">
                    <div class="bar"></div>
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script>
export default {};
</script>

<style scoped>
@keyframes loading {
    40% {
        background-position: 100% 0;
    }
    100% {
        background-position: 100% 0;
    }
}

*,
html {
    font-family: -apple-system, BlinkMacSystemFont, "Helvetica", "Arial",
        sans-serif;
    background: #fefefe;
}

.headline {
    text-align: center;
    margin-bottom: 48px;
}

.tableWrapper {
    width: 100%;
}

.table {
    margin: 0 auto;
    text-align: left;
    border-spacing: 0;
}

td {
    min-width: 150px;
}

span {
    color: #fefefe;
}

td:last-child {
    border-radius: 0 8px 8px 0;
}

.loading {
    position: relative;
}

.bar {
    background-color: #e7e7e7;
    height: 25px;
    border-radius: 12px;
    width: 80%;
    margin: 0 auto;
}

.loading:after {
    position: absolute;
    transform: translateY(-50%);
    top: 50%;
    left: 0;
    content: "";
    display: block;
    width: 100%;
    height: 24px;
    background-image: linear-gradient(
        100deg,
        rgba(255, 255, 255, 0),
        rgba(255, 255, 255, 0.5) 60%,
        rgba(255, 255, 255, 0) 80%
    );
    background-size: 200px 24px;
    background-position: -100px 0;
    background-repeat: no-repeat;
    animation: loading 1s infinite;
}
</style>
