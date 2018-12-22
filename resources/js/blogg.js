// Authentication
require('./blogg/auth')

// Syntax highlighting
require('./blogg/highlightJs')

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
Vue.component('Header', require('./blogg/components/Header.vue'));
Vue.component('Dashboard', require('./blogg/components/dashboard/Dashboard'))
Vue.component('DetailCard', require('./blogg/components/utility/DetailCard'))
Vue.component('flash', require('./blogg/components/utility/Flash.vue'));
