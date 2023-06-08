import { createStore } from "vuex";

const store = createStore({
    state() {
        return {
            count: 0
        }
    },
    getters: {
        count(state) {
            return state.count
        }
    },
    mutations: {
        increment(state) {
            state.count++
        },
        decrement(state) {
            state.count--
        }
    },
    actions: {
        increment(context) {
            // increment api
            context.commit('increment')
        },
        decrement(context) {
            // decrement api
            context.commit('decrement')
        }
    }
})

export default store