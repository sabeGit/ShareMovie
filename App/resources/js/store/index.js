import Vue from 'vue'
import Vuex from 'vuex'

import error from './error'
import noticeMessage from './noticeMessage'
import auth from './auth'
import movie from './movie'
import user from './user'


Vue.use(Vuex)

const store = new Vuex.Store({
    modules: {
        error,
        noticeMessage,
        auth,
        movie,
        user,
    }
})

export default store
