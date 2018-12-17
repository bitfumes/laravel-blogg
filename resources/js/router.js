import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

const routes = [{
        path: '/blog',
        component: require('./components/Header'),
        name: 'front.header'
    },
    {
        path: '/blog/dashboard',
        component: require('./components/dashboard/Dashboard'),
        name: 'dashboard'
    },
    {
        path: '/blog/dashboard/blog/create',
        component: require('./components/dashboard/blog/Create'),
        name: 'blog.create'
    },
    {
        path: '/blog/dashboard/blog/:id/edit/',
        component: require('./components/dashboard/blog/Edit'),
        name: 'blog.edit'
    },
    {
        path: '/blog/dashboard/blog',
        component: require('./components/dashboard/blog/Index'),
        name: 'blog.index'
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
