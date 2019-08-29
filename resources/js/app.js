/**
 * First, we will load all of this project's Javascript utilities and other
 * dependencies. Then, we will be ready to develop a robust and powerful
 * application frontend using useful Laravel and JavaScript libraries.
 */

require('./bootstrap');

import Vue from 'vue';
import Routes from './routes.js';

import App from './views/App';

import MenuComponent from './components/MenuComponent';

Vue.component('menu-component', MenuComponent);

const app = new Vue({
    el: '#app',
    components: {
        App
    },
    router: Routes,
});
