import VueRouter from 'vue-router';

let routes = [
    {
        name: 'home',
        path: '/',
    },
    {
        name: 'account.index',
        path: '/account',
        component: require('./views/account')
    },
    {
        name: 'account.edit',
        path: '/account/edit',
        component: require('./views/account/edit')
    },
    {
        name: 'account.password',
        path: '/account/password',
        component: require('./views/account/password')
    },

    // Rutas roles
    {
        name: 'roles.index',
        path: '/roles',
        component: require('./views/roles'),
    },
    {
        name: 'roles.create',
        path: '/roles/create',
        component: require('./views/roles/create'),
    },
    {
        name: 'roles.edit',
        path: '/roles/:id/edit',
        component: require('./views/roles/create'),
    },
    {
        name: 'roles.permissions',
        path: '/roles/:id/permissions',
        component: require('./views/roles/permissions'),
    },
    {
        name: 'roles.users',
        path: '/roles/:id/users',
        component: require('./views/roles/users'),
    },

    // Usuarios del sistema
    {
        name: 'users.index',
        path: '/users',
        component: require('./views/users'),
    },
    {
        name: 'users.create',
        path: '/users/create',
        component: require('./views/users/create'),
    },
    {
        name: 'users.show',
        path: '/users/:id',
        component: require('./views/users/show'),
    },
    {
        name: 'users.edit',
        path: '/users/:id/edit',
        component: require('./views/users/create'),
    }
];

export default new VueRouter({
    routes,
    linkActiveClass: 'active'
});