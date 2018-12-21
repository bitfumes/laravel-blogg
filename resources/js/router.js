import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

const routes = [{
        path: '/blog',
        component: require('./components/frontend/Index'),
        name: 'front.blog.index'
    },
    {
        path: '/blog/dashboard',
        component: require('./components/dashboard/Index'),
        name: 'dashboard',
        beforeEnter: (to, from, next) => isAdmin(next)
    },

    {
        path: '/blog/dashboard/blog/create',
        component: require('./components/dashboard/blog/Create'),
        name: 'blog.create',
        beforeEnter: (to, from, next) => isAdmin(next)
    },
    {
        path: '/blog/dashboard/blog/:slug/edit/',
        component: require('./components/dashboard/blog/Edit'),
        name: 'blog.edit',
        beforeEnter: (to, from, next) => isAdmin(next)
    },
    {
        path: '/blog/dashboard/blog',
        component: require('./components/dashboard/blog/Index'),
        name: 'blog.index',
        beforeEnter: (to, from, next) => isAdmin(next)
    },
    {
        path: '/blog/dashboard/tags',
        component: require('./components/dashboard/Tag'),
        name: 'tag',
        beforeEnter: (to, from, next) => isAdmin(next)
    },
    {
        path: '/blog/dashboard/categories',
        component: require('./components/dashboard/Category'),
        name: 'category',
        beforeEnter: (to, from, next) => isAdmin(next)
    },
    {
        path: '/blog/:category/:slug',
        component: require('./components/frontend/Show'),
        name: 'front.blog.show',
        meta: {
            metaTags: [{
                property: 'og:title',
                content: 'The home page of our example app.'
            }]
        }
    },
    {
        path: '*',
        redirect: {
            name: 'front.blog.index'
        }
    }
]

const router = new VueRouter({
    routes, // short for `routes: routes`,
    hashbang: false,
    mode: 'history'
})

// redirect if authenticated user is not admin
let isAdmin = (next) => auth.user.isAdmin ? next() : next('/blog')

// This callback runs before every route change, including on page load.
router.beforeEach((to, from, next) => {
    // This goes through the matched routes from last to first, finding the closest route with a title.
    // eg. if we have /some/deep/nested/route and /some, /deep, and /nested have titles, nested's will be chosen.
    const nearestWithTitle = to.matched.slice().reverse().find(r => r.meta && r.meta.title);

    // Find the nearest route element with meta tags.
    const nearestWithMeta = to.matched.slice().reverse().find(r => r.meta && r.meta.metaTags);
    const previousNearestWithMeta = from.matched.slice().reverse().find(r => r.meta && r.meta.metaTags);


    // If a route with a title was found, set the document (page) title to that value.
    if (nearestWithTitle) document.title = nearestWithTitle.meta.title;

    // Remove any stale meta tags from the document using the key attribute we set below.
    Array.from(document.querySelectorAll('[data-vue-router-controlled]')).map(el => el.parentNode.removeChild(el));

    // Skip rendering meta tags if there are none.
    if (!nearestWithMeta) return next();

    // Turn the meta tag definitions into actual elements in the head.
    nearestWithMeta.meta.metaTags.map(tagDef => {
            const tag = document.createElement('meta');

            Object.keys(tagDef).forEach(key => {
                tag.setAttribute(key, tagDef[key]);
            });

            // We use this to track which meta tags we create, so we don't interfere with other ones.
            tag.setAttribute('data-vue-router-controlled', '');

            return tag;
        })
        // Add the meta tags to the document head.
        .forEach(tag => {
            document.head.appendChild(tag);
        });

    next();
});

export default router
