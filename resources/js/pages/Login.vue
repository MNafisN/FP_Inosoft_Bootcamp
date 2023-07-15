<template>
    <div class="container-fluid position-absolute top-0 start-0">
        <div class="row no-gutter">
            <section class="vh-100" style="background-color: #508bfc">
                <div class="container py-5 h-100">
                    <div
                        class="row d-flex justify-content-center align-items-center h-100"
                    >
                        <div class="col-12 col-md-8 col-lg-6">
                            <div
                                class="card shadow-2-strong"
                                style="border-radius: 1rem"
                            >
                                <div class="card-body p-5 text-center">
                                    <h3 class="mb-5">SIGN IN</h3>
                                    <form @submit.prevent="handleSubmit">
                                        <div class="mb-4">
                                            <input
                                                type="email"
                                                v-model="email"
                                                placeholder="Email"
                                                class="form-control form-control-lg"
                                                required
                                            />
                                        </div>

                                        <div class="mb-4">
                                            <input
                                                type="password"
                                                v-model="password"
                                                placeholder="Password"
                                                class="form-control form-control-lg"
                                                required
                                            />
                                        </div>
                                        <div class="d-grid mt-5">
                                            <button
                                                class="btn btn-primary btn-lg"
                                                type="submit"
                                            >
                                                <div
                                                    v-if="loading"
                                                    class="spinner-border"
                                                    role="status"
                                                    style="
                                                        width: 1.3rem;
                                                        height: 1.3rem;
                                                        border-width: 2px;
                                                    "
                                                >
                                                    <span
                                                        class="visually-hidden"
                                                        >Loading...</span
                                                    >
                                                </div>
                                                <span v-else>LOGIN</span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            email: "",
            password: "",
            loading: false,
        };
    },
    methods: {
        handleSubmit() {
            this.loading = true;
            const payload = {
                email: this.email,
                password: this.password,
            };

            axios
                .post("http://127.0.0.1:8000/api/auth/login", payload)
                .then((res) => {
                    this.loading = false;
                    this.email = "";
                    this.password = "";
                    localStorage.setItem(
                        'access_token',
                        res.data.access_token
                    );
                    this.$router.push('/app');
                })
                .catch((err) => {
                    this.loading = false;
                    console.log(err);
                });
        },
    },
};
</script>

<style scoped></style>
