import { OK } from '../util'

const state = {
    posts: null,
    apiStatus: null
}

const getters = {
    posts: state => state.posts
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
        console.log(response)
        if (response.status === OK) {
            context.commit('setApiStatus', true);
            context.commit('movie/setMovies', response.data, { root: true });
            return false;
        }
    },
}

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions
}
