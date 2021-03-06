import Vue from 'vue'
import VueRouter from 'vue-router'

import Home from './pages/others/Home.vue'
import Login from './pages/auth/Login.vue'
import Register from './pages/auth/Register.vue'
import PreRegister from './pages/auth/PreRegister.vue'
import RegisterVerified from './pages/auth/RegisterVerified.vue'
import PasswordForgot from './pages/auth/PasswordForgot.vue'
import PasswordForgotFinish from './pages/auth/PasswordForgotFinish.vue'
import PasswordReset from './pages/auth/PasswordReset.vue'
import MovieSearchResult from './pages/movies/MovieSearchResult.vue'
import MovieDetail from './pages/movies/MovieDetail.vue'
import UserDetail from './pages/users/UserDetail.vue'
import UserSetting from './pages/users/UserSetting.vue'
import SystemError from './pages/errors/System.vue'

import store from './store'

Vue.use(VueRouter)

const routes = [
    {
        path: '/',
        name: 'Home',
        component: Home
    },
    {
        path: '/login',
        name: 'Login',
        component: Login,
        beforeEnter (to, from, next) {
            if (store.getters['auth/check']) {
                next('/');
            } else {
                next();
            }
        }
    },
    {
        path: '/register',
        name: 'Register',
        component: Register
    },
    {
        path: '/pre-register',
        name: 'PreRegister',
        component: PreRegister
    },
    {
        path: '/password/send',
        name: 'PasswordForgot',
        component: PasswordForgot
    },
    {
        path: '/password/sent',
        name: 'PasswordForgotFinish',
        component: PasswordForgotFinish
    },
    {
        path: '/password/reset/:token',
        name: 'PasswordReset',
        component: PasswordReset
    },
    {
        path: '/register/verify/:token',
        name: 'RegisterVerified',
        component: RegisterVerified
    },
    {
        path: '/500',
        name: 'SystemError',
        component: SystemError
    },
    {
        path: '/user/:username/:option',
        name: 'UserDetail',
        component: UserDetail
    },
    {
        path: '/setting/:option',
        name: 'UserSetting',
        component: UserSetting
    },
    {
        path: '/movie/show/:id',
        name: 'MovieDetail',
        component: MovieDetail
    },
    {
        path: '/movie/search',
        name: 'MovieSearchResult',
        component: MovieSearchResult,
        props: (route) => ({ freeword: route.query.freeword })
    }
]

const router = new VueRouter({
    mode: 'history',
    routes
})

export default router
