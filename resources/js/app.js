/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

import App from './App.vue';
import VueRouter from 'vue-router';
import VueAxios from 'vue-axios';
import Axios from 'axios';
import {routes} from './routes';

import VueSidebarMenu from 'vue-sidebar-menu'
import 'vue-sidebar-menu/dist/vue-sidebar-menu.css'

import VueGoodTablePlugin from 'vue-good-table'
import 'vue-good-table/dist/vue-good-table.css'

Vue.config.prodEnv = false
const config = require('./config')
window.API_URL = (Vue.config.prodEnv) ? config.PRODUCTION_URL : config.DEVELOPMENT_URL

Vue.use(VueRouter)
Vue.use(VueAxios, Axios)
Vue.use(VueSidebarMenu)
Vue.use(VueGoodTablePlugin)

// var dt = require( 'datatables.net' )();

const router = new VueRouter({
    mode: 'history',
    routes: routes
});

// Vue.component('main-component', require('./components/MainComponent.vue').default);
// Vue.component('supplier-list-component', require('./components/SupplierListComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router: router,
    render: h => h(App),
});
