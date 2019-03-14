import { OK, UNAUTHORIZED } from '../util'

const state = {
    user: null,
    apiStatus: null
}

const getters = {
    profileImage: state => state.user ? state.user.profile_image : '',
    username: state => state.user ? state.user.name : '',
    user: state => state.user
}

const mutations = {
    setUser (state, user) {
        state.user = user;
    },
    setApiStatus (state, status) {
        state.apiStatus = status;
    }
}

const actions = {
    // 引数usernameからuser情報を取得
    async setUser (context, username) {
        context.commit('setApiStatus', null);
        context.commit('movie/setMovies', null, { root: true });
        context.commit('post/setPosts', null, { root: true });
        const response = await axios.get('/api/user', {
            params: {
                username
            }
        });
        console.log(response.data)
        if (response.status === OK) {
            context.commit('setApiStatus', true);
            context.commit('setUser', response.data);
            context.commit('movie/setMovies', response.data.movies, { root: true });
            context.commit('post/setPosts', response.data.posts, { root: true });
            return false;
        }
    },
    async setUpAccount (context, setUpInfo) {
        context.commit('setApiStatus', null);
        const response = await axios.post('/api/user/account', {
            params: {
                setUpInfo
            }
        });
        console.log(response);
        if (response.status === OK) {
            context.commit('setApiStatus', true);
            context.commit('setUser', response.data);
            return false;
        } else if (response.status === UNAUTHORIZED) {
            context.commit('auth/setBeforeAuthPagePath', location.pathname, { root: true });
        }
        context.commit('error/setCode', response.status, { root: true });
    },
    async editFavoriteMovie (context, { favorite, movie }) {
        context.commit('setApiStatus', null);
        const response = await axios.post('/api/user/movie/fav',{
            favorite: favorite,
            movie: movie,
        });
        if (response.status === OK) {
            context.commit('setApiStatus', true);
            context.commit('movie/setMovies', response.data.movies, { root: true });
            return false;
        } else if (response.status === UNAUTHORIZED) {
            context.commit('auth/setBeforeAuthPagePath', location.pathname, { root: true });
        }
        context.commit('error/setCode', response.status, { root: true });
    },
    async editWatchedMovie (context, { watched, movie }) {
        context.commit('setApiStatus', null);
        const response = await axios.post('/api/user/movie/watched',{
            watched: watched,
            movie: movie,
        });
        if (response.status === OK) {
            context.commit('setApiStatus', true);
            context.commit('movie/setMovies', response.data.movies, { root: true });
            return false;
        } else if (response.status === UNAUTHORIZED) {
            context.commit('auth/setBeforeAuthPagePath', location.pathname, { root: true });
        }
        context.commit('error/setCode', response.status, { root: true });
    },
    async editMovieRating (context, { rating, movie }) {
        context.commit('setApiStatus', null);
        const response = await axios.post('/api/user/movie/rating',{
            rating: rating,
            movie: movie,
        });
        if (response.status === OK) {
            context.commit('setApiStatus', true);
            context.commit('movie/setMovies', response.data.movies, { root: true });
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
