try {
    window.$ = window.jQuery = require('jquery');
} catch (e) {}

window.api = 'http://blogg.test'
// Require Axios
require('./resources/axios')

// Authentication
require('./resources/auth')

// Syntax highlighting
require('./resources/highlightJs')


// Import global vue
import Vue from 'vue'

// Vuetify
import Vuetify from 'vuetify'
Vue.use(Vuetify)

// Markdown editor
import VueSimplemde from 'vue-simplemde'
import 'simplemde/dist/simplemde.min.css'
Vue.use(VueSimplemde)

// Some global components
Vue.component('Header', require('./components/Header.vue'));
Vue.component('Dashboard', require('./components/dashboard/Dashboard'))
Vue.component('DetailCard', require('./components/utility/DetailCard'))
Vue.component('flash', require('./components/utility/Flash.vue'));
