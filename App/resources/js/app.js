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
