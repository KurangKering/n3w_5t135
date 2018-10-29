

require('./bootstrap');
require('admin-lte');

import Vue from 'vue';
import Vuex from 'vuex';
import VueRoter from 'vue-router';

Vue.component('example-component', require('./components/ExampleComponent.vue'));

const app = new Vue({
    el: '#app'
});
