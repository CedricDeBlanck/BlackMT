/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import Vue from 'vue';
import route from 'ziggy-js';
import { Ziggy } from "./ziggy";

window.Vue = require('vue').default;

Vue.mixin({
    methods: {
        route: (name, params, absolute) => route(name, params, absolute, Ziggy),
    }
});

const app = new Vue({
    el: '#app',
    components: {
        'home-component': require('./components/HomeComponent.vue').default,
        'strafblad-component': require('./components/StrafbladComponent.vue').default,
        'accounts-component': require('./components/AccountsComponent.vue').default,
    },

});
