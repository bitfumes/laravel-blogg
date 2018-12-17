import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

const routes = [{
        path: '/blog',
        component: require('./components/Header')
    },
    {
        path: '/blog/dashboard',
        component: require('./components/dashboard/Dashboard')
    },
    {
        path: '/blog/dashboard/create',
        component: require('./components/dashboard/create')
    },
    {
        path: '/blog/dashboard/tags',
        component: require('./components/dashboard/Tag'),
        name: 'tag'
    },
    {
        path: '/blog/dashboard/categories',
        component: require('./components/dashboard/Category'),
        name: 'category'
    },
]

const router = new VueRouter({
    routes, // short for `routes: routes`,
    hashbang: false,
    mode: 'history'
})


export default router
