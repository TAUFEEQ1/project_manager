import Vue from 'vue'
import VueRouter from 'vue-router'
import  BootstrapVue from 'bootstrap-vue'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import axios from 'axios'
import { Chart } from 'chart.js'
Vue.prototype.$axios = axios
Vue.prototype.$chart = Chart
Vue.use(BootstrapVue)
Vue.use(VueRouter)

import App from './views/App'
import Forgot from './views/Forgot'
import Home from './views/Home'
import Dashboard from './views/Dashboard'
import Projects from './views/Projects'
import SingleP from './views/SingleP'
import Tasks from './views/Tasks'
import Edittask from './views/Edittask'
import Resources from './views/Resources'
//import Workers from './views/Workers'
//import Metadata from './views/Metadata'

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home
        },
        {
            path: '/forgot',
            name: 'forgot',
            component: Forgot,
        },
        {
        	path: '/dashboard',
        	component: Dashboard,
            children:[
                {
                    path:'',
                    name:'projects',
                    component: Projects
                },
                {
                    path:'projects',
                    name:'projects',
                    component:Projects
                },
                {
                    path:'tasks',
                    name:'tasks',
                    component:Tasks
                },
                {
                    path:'edittask',
                    component: Edittask,
                    children:[
                        {
                            path:'',
                            name:'resources',
                            component:Resources,
                        },
                        {
                            path:'resources/:taskid',
                            name:'resources',
                            component:Resources
                        }

                    ]
                }
            ],
        },
    ],
});

const app = new Vue({
    el: '#app',
    components: { App },
    router,
});