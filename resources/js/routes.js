import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

import NotFound from './views/errors/NotFound';
import UsersIndex from './views/UsersIndex';
import UsersEdit from './views/UsersEdit';
import UsersCreate from './views/UsersCreate';

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/404',
            name: '404',
            component: NotFound
        },
        {
            path: '*',
            redirect: '/404'
        },
        {
            path: '/',
            name: 'home',
            redirect: {
                name: 'users.index'
            }
        },
        {
            path: '/users',
            name: 'users.index',
            component: UsersIndex,
        },
        {
            path: '/users/:id/edit',
            name: 'users.edit',
            component: UsersEdit,
        },
        {
            path: '/users/create',
            name: 'users.create',
            component: UsersCreate,
        },
    ],
});

export default router;
