import Vue from 'vue'
import VueRouter from 'vue-router'
import  BootstrapVue from 'bootstrap-vue'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import axios from 'axios'
import { Chart } from 'chart.js'
import 'd3/d3.min.js'
// import sigma from 'sigma'
const sigma = require('sigma'); (window).sigma = sigma; 
require('sigma/build/plugins/sigma.renderers.edgeLabels.min.js');
import { GoogleCharts } from 'google-charts'
Vue.prototype.$GoogleCharts = GoogleCharts;
(window).GoogleCharts = GoogleCharts;
Vue.prototype.$axios = axios
Vue.prototype.$chart = Chart
//Vue.prototype.$jsnx = jsnx;
//Vue.prototype.$d3 = d3;
Vue.use(BootstrapVue)
Vue.prototype.$sigma = sigma;
Vue.use(VueRouter)
import App from './views/App'
import Forgot from './views/Forgot'
import Home from './views/Home'
import Dashboard from './views/Dashboard'
import Projects from './views/Projects'
import Details from './views/Details'
import Tasks from './views/Tasks'
import Edittask from './views/Edittask'
import Resources from './views/Resources'
import Graphs from './views/Graphs'
import Archived from './views/Archived'
import Workers from './views/Workers'

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
                    path:'archived',
                    name:'archived',
                    component:Archived
                },
                {
                    path:'tasks',
                    name:'tasks',
                    component:Tasks
                },
                {
                    path:'details',
                    component:Details,
                    children:[
                        {
                            path:'',
                            name:'graphs',
                            component:Graphs
                        }
                    ]
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