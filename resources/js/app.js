require('./bootstrap');

// window.Vue = require('vue');

import Vue from 'vue'
import Vuetify from 'vuetify'
Vue.use(Vuetify)

// Markdown editor
import VueSimplemde from 'vue-simplemde'
import 'simplemde/dist/simplemde.min.css'
Vue.use(VueSimplemde)


window.Event = new Vue();
window.flash = function (message, color = 'success') {
    Event.$emit('flash', {
        message,
        color
    })
}

Vue.component('Header', require('./components/Header.vue'));
Vue.component('Dashboard', require('./components/dashboard/Dashboard'))
Vue.component('flash', require('./components/utility/Flash.vue'));

import router from './router.js'
const app = new Vue({
    el: '#blogg',
    router
});
