require('./blogg');

import Vue from 'vue'

window.Event = new Vue();

import VueRouter from 'vue-router'
import routes from './routes/router.js'
Vue.use(VueRouter)

const router = new VueRouter({
    routes, // short for `routes: routes`,
    hashbang: false,
    mode: 'history'
})

const app = new Vue({
    el: '#blogg',
    router,
});
