<template>
    <div v-if="isShow" class="modal-background">
        <div class="modal-wrapper">
            <div class="d-flex m-1 pointer" @click="showToggle">
                <p class="mb-0 me-1 text-white">close</p>
                <div class="i-close"></div>
            </div>
            <div class="w-100 p-4 bg-white rounded">
                <p class="text-center fw-bold">Internal Note</p>
                <span class="d-block fs-7">by User</span>
                <textarea class="w-100 border rounded py-1 px-2" rows="5" :value="textBox" @input="e=> textBox = e.target.value"></textarea>
                <br>
                <br>
                <div class="d-flex justify-content-end align-items-center">
                    <span class="pointer" @click="showToggle">Cancle</span>
                    <button class="bg-primary-custom py-2 my-2 w-180px rounded d-flex justify-content-center align-items-center border-0 text-white fw-medium submit ms-5" @click="submit">
                        Submit
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div>
        <div>
            <div v-for="(note, index) in internalNotes" class="mb-3">
                <div class="d-flex justify-content-between w-100">
                    <span class="fs-7">{{ title(note.posted_by, note.date_posted) }}</span>
                    <div class="d-flex gap-3">
                        <div class="i-delete pointer" @click="deleteNotes(index)"></div>
                        <div class="i-modify pointer" @click="modifyNotes(index)"></div>
                    </div>
                </div>
                <div class="w-100 rounded bg-secondary-subtle p-3">
                    <p class="m-0">{{ note.note }}</p>
                </div>
            </div>
        </div>
        <button class="bg-primary-custom py-2 my-2 w-180px rounded d-flex justify-content-center align-items-center gap-1 border-0" @click="showToggle">
            <div class="i-plus"></div>
            <span class="text-white fw-semibold"> Add Internal Notes</span>
        </button>
    </div>
</template>

<script>
import axios from 'axios';
import moment from 'moment';
export default {
    name: 'internal-notes',
    data() {
        return {
            isShow: false,
            textBox: "",
            indexEdit: -1
        }
    },
    computed: {
        internalNotes() {
            return this.$store.getters.getNotesInternalOnlyAll
        }
    },
    methods: {
        title(user, time) {
            return `by ${user} on ${time}`
        },
        showToggle() {
            this.isShow === false ? this.isShow = true : this.isShow = false
            this.indexEdit = -1
        },
        submit() {
            // const data = {
            //     note: this.textBox,
            //     time: moment().format('DD/MM/YY hh:mm A')
            // }
            if(this.indexEdit === -1){
                this.$store.dispatch('addNotesInternalOnly', this.textBox)
            } else {
                this.$store.dispatch('updateNotesInternalOnly', {note: this.textBox, index: this.indexEdit})
            }
            this.textBox = ""
            this.showToggle()
        },
        deleteNotes(index) {
            this.$store.dispatch('deleteNotesInternalOnly', index)
        },
        modifyNotes(index) {
            this.indexEdit = index
            this.textBox = this.$store.getters.getNotesInternalOnly(index)
            this.isShow = true
        }
    }
}
</script>

<style scoped>
.submit {
    width: 200px;
    height: 50px;
}

</style>
