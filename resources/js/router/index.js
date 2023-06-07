import { createRouter, createWebHistory } from "vue-router";
import Home from '../pages/Home.vue'
import About from '../pages/About.vue'

const routes = [
    {
        path: '/app',
        component: Home
    },
    {
        path: '/app/about',
        component: About
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router