import { OK } from '../util'

const state = {
    user: null,
    apiStatus: null
}

const getters = {
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
        const response = await axios.get('/api/user', {
            params: {
                username
            }
        });
        if (response.status === OK) {
            context.commit('setApiStatus', true);
            context.commit('setUser', response.data);
            return false;
        }
    },
    async getAllAttachedMovies (context, username) {
        context.commit('setApiStatus', null);
        const response = await axios.get('/api/user/movie', {
            params: {
                username
            }
        });
        if (response.status === OK) {
            context.commit('setApiStatus', true);
            context.commit('movie/setMovies', response.data, { root: true });
            return false;
        }
    },
    async editFavoriteMovie (context, { favorite, movie }) {
        context.commit('setApiStatus', null);
        const response = await axios.post('/api/user/movie/fav',{
            favorite: favorite,
            movie: movie,
        });
        if (response.status === OK) {
            context.commit('setApiStatus', true);
            context.commit('movie/setMovies', response.data, { root: true });
            return false;
        }
    },
    async editWatchedMovie (context, { watched, movie }) {
        context.commit('setApiStatus', null);
        const response = await axios.post('/api/user/movie/watched',{
            watched: watched,
            movie: movie,
        });
        if (response.status === OK) {
            context.commit('setApiStatus', true);
            context.commit('movie/setMovies', response.data, { root: true });
            return false;
        }
    },
    async editMovieRating (context, { rating, movie }) {
        context.commit('setApiStatus', null);
        const response = await axios.post('/api/user/movie/rating',{
            rating: rating,
            movie: movie,
        });
        console.log(response.data)
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
