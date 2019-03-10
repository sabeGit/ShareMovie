import { OK } from '../util'

const state = {
    movies: null,
    filteredMovies: null,
    isFavFilter: false,
    isWatchedFilter: false,
    isRatingFilter: false,
    apiStatus: null,
}

const getters = {
    movies: state => state.movies,
    filteredMovies: state => {
        if (state.movies && state.isFavFilter) {
            return state.movies.filter(movie => movie.pivot.favorite);
        } else if (state.movies && state.isWatchedFilter) {
            return state.movies.filter(movie => movie.pivot.watched);
        } else if (state.movies && state.isRatingFilter) {
            return state.movies.filter(movie => movie.pivot.rating > 0);
        }
        return null;
    },
    favMovies: state => {
        return state.movies ? state.movies.filter(movie => movie.pivot.favorite) : null
    },
    watchedMovies: state => {
        return state.movies ? state.movies.filter(movie => movie.pivot.watched) :null
    },
    watchedMoviesCount: state => {
        //return state.movies ? state.movies.filter(movie => movie.users[0].pivot.watched).length : 0
        return state.movies ? state.movies.filter(movie => movie.pivot.watched).length : 0
    },
    favMoviesCount: state => {
        // return state.movies ? state.movies.filter(movie => movie.users[0].pivot.favorite).length : 0
        return state.movies ? state.movies.filter(movie => movie.pivot.favorite).length : 0
    },
}

const mutations = {
    setMovies (state, movies) {
        state.movies = movies;
    },
    filterFavorite (state) {
        state.isFavFilter = true;
        state.isWatchedFilter = false;
        state.isRatingFilter = false;
    },
    filterWatched (state) {
        state.isFavFilter = false;
        state.isWatchedFilter = true;
        state.isRatingFilter = false;
    },
    filterRating (state) {
        state.isFavFilter = false;
        state.isWatchedFilter = false;
        state.isRatingFilter = true;
    },
    setApiStatus (state, status) {
        state.apiStatus = status;
    }
}

const actions = {
    async getMovieById (context, { movieId, userId }) {
        context.commit('setApiStatus', null);
        context.commit('post/setPosts', null, { root: true });
        const response = await axios.get('/api/movie', {
            params: {
                movieId: movieId,
                userId: userId
            }
        });
        console.log(response.data)
        if (response.status === OK) {
            context.commit('setApiStatus', true);
            context.commit('post/setPosts', response.data.posts, { root: true });
            return response.data;
        }
    },
    async search (context, freeword) {
        context.commit('setApiStatus', null);
        const response = await axios.get('/api/movie/search', {
            params: {
                freeword: freeword
            }
        });
        if (response.status === OK) {
            context.commit('setApiStatus', true);
            context.commit('setMovies', response.data);
            return false;
        }
    }
}

export default {
    namespaced: true,
    getters,
    state,
    mutations,
    actions
}
