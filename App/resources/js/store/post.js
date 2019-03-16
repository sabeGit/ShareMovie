import { OK, UNAUTHORIZED } from '../util'

const state = {
    posts: null,
    apiStatus: null
}

const getters = {
    posts: state => state.posts,
    postsCount: state => {
        return state.posts ? state.posts.length : 0
    },
}

const mutations = {
    setPosts (state, posts) {
        state.posts = posts;
    },
    setApiStatus (state, status) {
        state.apiStatus = status;
    }
}

const actions = {
    async postContent (context, { content, movie }) {
        context.commit('setApiStatus', null);
        const response = await axios.post('/api/posts',{
            content: content,
            movie: movie,
        });
        if (response.status === OK) {
            context.commit('setApiStatus', true);
            context.commit('movie/setMovies', response.data, { root: true });
            return false;
        } else if (response.status === UNAUTHORIZED) {
            context.commit('auth/setBeforeAuthPagePath', location.pathname, { root: true });
        }
        context.commit('error/setCode', response.status, { root: true });
    },
}

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions
}
