/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import moment from 'moment'

import swal from 'sweetalert2'
import {AlertError, Form, HasError} from 'vform'
import VueRouter from 'vue-router'
import VueProgressBar from 'vue-progressbar'
import Datepicker from 'vuejs-datepicker';

window.swal = swal;


window.Form = Form;
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)

Vue.use(Datepicker)
Vue.use(VueRouter)


Vue.component('pagination', require('laravel-vue-pagination'));

const toast = swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});
window.toast = toast;

Vue.use(VueProgressBar, {
    color: 'rgb(143, 255, 199)',
    failedColor: 'red',
    height: '3px'
})

let routes = [
    {path: '/phases', component: require('./components/Phases.vue').default},
    {path: '/disbursment', component: require('./components/Disbursements.vue').default},
    {path: '/projects', component: require('./components/Projects.vue').default},
    {path: '/status', component: require('./components/Status.vue').default},
    {path: '/country', component: require('./components/Country.vue').default},
]


window.Fire = new Vue();


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

const router = new VueRouter({
    mode: 'history',
    routes
})


Vue.filter('custom_date', function (date) {
    return moment(date).format('MMMM Do YYYY');
})
Vue.filter('custom_user_type', function (type) {
    var return_type = ""

    if (type == 1) {
        return_type = "Admin";
    } else if (type == 2) {
        return_type = "Standard User";
    } else if (type == 3) {
        return_type = "Author";
    }
    return return_type;
});
Vue.filter('ready_nap', function (type) {
    var return_type = ""

    if (type == 1) {
        return_type = "Readiness";
    } else if (type == 2) {
        return_type = "NAP";
    }
    return return_type;
});

Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue').default
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue').default
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue').default
);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app', router
});
