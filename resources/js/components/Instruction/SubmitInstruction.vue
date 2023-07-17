<template>
    <div
        class="bg-white w-100 rounded-top shadow p-3 d-flex justify-content-end align-items-center gap-4"
    >
        <router-link to="/app" class="text-black text-decoration-none">
            <span class="fs-7">Cancle</span>
        </router-link>
        <button class="btn border fw-medium fs-7 draft" @click="draft">
            Save as Draft
        </button>
        <button class="bg-primary-custom py-2 my-2 w-180px rounded d-flex justify-content-center border-0 text-white fw-medium" @click="submit">
            Submit
        </button>
    </div>
</template>

<script>
export default {
    name: "submit-instruction",
    props: {
        type: String,
    },
    computed: {
        instructionData() {
            return this.$store.getters.getInstructionDetail
        },
        getId() {
            return this.$store.getters.getId
        }
    },
    methods: {
        submit() {
            try {
                if (this.type === "edit") {
                    // this.$store.dispatch("editInstruction");
                    axios.put("/api/instruction/update", this.instructionData)
                    .then((json) =>{
                        console.log(json.data)
                        this.$router.push('/app/detail-instruction/'+this.getId)
                    });

                } else {
                    // this.$store.dispatch('submitInstruction')
                    this.$store.commit("updateStatus", "In Progress");
                    const { instruction_id, ...other } = this.instructionData
                    console.log(other);
                    axios.post("/api/instruction/add", other)
                    .then((json) => {
                        // this.$store.commit("updateInstructionId", json.data.instruction.instruction_id);
                        this.$router.push('/app/detail-instruction/'+json.data.instruction.instruction_id)
                    })
                }
            } catch (err) {
                alert(err.message);
            } finally {
                this.$router.push("/app");
            }
        },
        draft() {
            this.$store.dispatch("saveAsDraft");
            this.$router.push("/app");
        },
    },
};
</script>

<style scoped>
.draft {
    width: 150px;
    height: 40px;
}
.submit {
    width: 180px;
    height: 40px;
}
</style>
