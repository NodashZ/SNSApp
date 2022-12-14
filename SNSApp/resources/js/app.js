/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

// window.Vue = require('vue');
import Vue from 'vue'

import store from './store.js'

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('header-component', require('./components/Header.vue').default);

Vue.component('post-create', require('./components/PostCreate.vue').default);
Vue.component('post-edit', require('./components/PostEdit.vue').default);
Vue.component('post-list', require('./components/PostList.vue').default);
Vue.component('post-message', require('./components/Message.vue').default);
Vue.component('post-component', require('./components/PostComponent.vue').default);

Vue.component('follow-list', require('./components/FollowList.vue').default);
Vue.component('chat', require('./components/Chat.vue').default);
Vue.component('maru-batsu', require('./components/MaruBatsu.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    store: store, // ストアを追加する vuex
});
