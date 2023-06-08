import './bootstrap';
import { createApp } from 'vue';
import vue from './App.vue';
import router from './router';
import store from './store';
import 'bootstrap/dist/css/bootstrap.css'

createApp(vue)
.use(router)
.use(store)
.mount('#app')