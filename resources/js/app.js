/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import VueRouter from "vue-router";
import { routes } from './routes';
import Auth from './auth'

Vue.use(VueRouter);
Vue.use(Auth);

const router = new VueRouter({
    routes,
    mode: 'history',
})

router.beforeEach((to, from, next) => {
    document.title = to.meta.title;

    if(localStorage.getItem('user')){
        let user = JSON.parse(localStorage.getItem('user'));
        if (to.meta.forAuth) {
            if((user.id === 1 && to.meta.forAdmin) || (user.id !== 1 && !to.meta.forAdmin)){
                next();
            }
        }
        next({
            path: user.id === 1 ? '/list' : '/application'
        });
    }else{
        if (to.meta.forAuth) {
            next({
                path: '/login'
            });
        }else{
            next();
        }
    }


});

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('login', require('./components/Login.vue').default);
Vue.component('register', require('./components/Register.vue').default);
Vue.component('navbar', require('./components/Navbar').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    props: ['clientSecret'],
    router,
    data(){
        return{
            user: localStorage.getItem('user')
        }
    },
    watch: {
        '$route' (to, from) {
            this.user = localStorage.getItem('user') ? localStorage.getItem('user') : null;
        }
    },
}).$mount('#app');
