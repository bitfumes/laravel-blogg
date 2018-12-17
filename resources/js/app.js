import VueRouter from 'vue-router'

require('./bootstrap');

window.Vue = require('vue');



import router from './router.js'

import Vue from 'vue'
import Vuetify from 'vuetify'
Vue.use(Vuetify)

Vue.component('Header', require('./components/Header.vue'));
// Vue.component('Dashboard', require('./components/dashboard/Dashboard.vue'));

// Markdown editor
import VueSimplemde from 'vue-simplemde'
import 'simplemde/dist/simplemde.min.css'
Vue.use(VueSimplemde)

// Tag Input
import InputTag from "vue-input-tag";
Vue.component("input-tag", InputTag);

// Select Menu
// import vSelect from 'vue-select';
// Vue.component('v-select', vSelect)


window.Event = new Vue();
window.flash = function (message, color = 'success') {
    Event.$emit('flash', {
        message,
        color
    })
}

Vue.component('Dashboard', require('./components/dashboard/Dashboard'))
Vue.component('flash', require('./components/utility/Flash.vue'));

const app = new Vue({
    el: '#blogg',
    router
});
