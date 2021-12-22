import { createApp } from 'vue'
// import Notifications from 'notiwind'
import App from './App.vue'
import router from "./router";
import store from "./store/index";
import './assets/style.css'
import Notifications from 'notiwind'

createApp(App) 
    .use(router)
    .use(store)
    .use(Notifications)
    .mount('#app')
