import { createRouter, createWebHistory } from "vue-router";
import Home from '../pages/Home.vue'
import CreateInstruction from '../pages/CreateInstruction.vue'
import EditInstruction from '../pages/EditInstruction.vue'
import DetailInstruction from '../pages/DetailInstruction.vue'

const routes = [
    {
        path: '/app',
        component: Home
    },
    {
        path: '/app/create-instruction',
        component: CreateInstruction
    },
    {
        path: '/app/edit-instruction',
        component: EditInstruction
    },
    {
        path: '/app/detail-instruction',
        component: DetailInstruction
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router