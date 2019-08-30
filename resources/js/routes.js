import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

import NotFound from './views/NotFound';
import Hello from './views/Hello';
import Home from './views/Home';
import UsersIndex from './views/UsersIndex';
import UsersEdit from './views/UserEdit';

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
            component: Home
        },
        {
            path: '/hello',
            name: 'hello',
            component: Hello,
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
    ],
});

export default router;
