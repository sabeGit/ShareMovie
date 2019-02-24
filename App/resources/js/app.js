// import Vue from 'vue'
// import VueRouter from 'vue-router'
//
// require('./bootstrap');
//
// window.Vue = require('vue');
//
// Vue.use(VueRouter)
//
// Vue.component(
//     'passport-clients',
//     require('./components/passport/Clients.vue')
// );
//
// Vue.component(
//     'passport-authorized-clients',
//     require('./components/passport/AuthorizedClients.vue')
// );
//
// Vue.component(
//     'passport-personal-access-tokens',
//     require('./components/passport/PersonalAccessTokens.vue')
// );
//
// //Vue.component('navbar', require('./components/layouts/Navbar.vue'));
// Vue.component('user-navbar', require('./components/users/UserNavbar.vue'));
//
// Vue.component('show-actions', require('./components/movies/ShowActions.vue'));
//
// Vue.component('review-modal', require('./components/movies/ReviewModal.vue'));
//
// const router = new VueRouter({
//     mode: 'history',
//     routes: [
//         { path: '/', component: require('./components/microposts/Index.vue') },
//         { path: '/search', component: require('./components/movies/Search.vue') },
//         { path: '/about', component: require('./components/About.vue') },
//     ]
// })
//
// const app = new Vue({
//     router,
//     el: '#app'
// })

import './bootstrap'
import Vue from 'vue'
import router from './router'
import store from './store'
import App from './App.vue'

const createApp = async () => {
    if (store.state.auth.isLoggedIn) {
        await store.dispatch('auth/currentUser');
    }
    new Vue({
      el: '#app',
      router,
      store,
      components: { App },
      template: '<App />'
    })
}

createApp();
