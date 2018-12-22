require('./bootstrap');
require('./blogg');

// window.Vue = require('vue');

import Vue from 'vue'

window.Event = new Vue();
window.flash = function (message, color = 'success') {
    Event.$emit('flash', {
        message,
        color
    })
}

import router from './blogg/router.js'
const app = new Vue({
    el: '#blogg',
    router,
});
