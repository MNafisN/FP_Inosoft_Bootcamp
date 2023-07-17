import { createRouter, createWebHistory } from "vue-router";
import Login from '../pages/Login.vue'
import Home from '../pages/Home.vue'
import CreateInstruction from '../pages/CreateInstruction.vue'
import EditInstruction from '../pages/EditInstruction.vue'
import DetailInstruction from '../pages/DetailInstruction.vue'

const routes = [
    {
        path: '/app/login',
        component: Login,
        meta:{
            guestOnly: true
        }
    },
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
        path: '/app/detail-instruction/:id',
        component: DetailInstruction
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

const checkIfUserIsAuthenticated = () => {
    const accessToken = localStorage.getItem('access_token')
    return !!accessToken
}

router.beforeEach((to, from, next) => {
    const guestOnly = to.matched.some((route) => route.meta.guestOnly)

    const isAuthenticated = checkIfUserIsAuthenticated()

    if (!guestOnly & !isAuthenticated) {
        next('app/login')
    } else if(guestOnly & isAuthenticated){
        next('app')
    } else {
        next()
    }
})

export default router