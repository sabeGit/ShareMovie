import { OK, UNAUTHORIZED } from '../util'

const state = {
    posts: [],
    apiStatus: null
}

const getters = {
    // postsを受渡
    posts: state => state.posts,
    // postsの数を受渡
    postsCount: state => {
        return state.posts ? state.posts.length : 0
    },
}

const mutations = {
    // 取得したpostを配列に保管
    setPosts (state, posts) {
        state.posts = posts;
    },
    // 最新のpostを追加
    addPost (state, post) {
        state.posts.unshift(post);
    },
    // APIコール結果を保管
    setApiStatus (state, status) {
        state.apiStatus = status;
    }
}

const actions = {
    // postを作成
    async postContent (context, { content, movie }) {
        context.commit('setApiStatus', null);
        const response = await axios.post('/api/posts',{
            content: content,
            movie: movie,
        });
        if (response.status === OK) {
            context.commit('setApiStatus', true);
            context.commit('post/addPost', response.data.posts, { root: true });
            return true;
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
