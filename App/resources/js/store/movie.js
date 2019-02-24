import { OK } from '../util'

const state = {
    movies: null,
    filteredMovies: null,
    isFavFilter: false,
    isWatchedFilter: false,
    apiStatus: null,
}

const getters = {
    movies: state => state.movies,
    filteredMovies: state => {
        if (state.movies && state.isFavFilter) {
            return state.movies.filter(movie => movie.users[0].pivot.favorite);
        } else if (state.movies && state.isWatchedFilter) {
            return state.movies.filter(movie => movie.users[0].pivot.watched);
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
        return state.movies ? state.movies.filter(movie => movie.users[0].pivot.watched).length : 0
    },
    favMoviesCount: state => {
        console.log(state.movies)
        return state.movies ? state.movies.filter(movie => movie.users[0].pivot.favorite).length : 0
    },
    // avgRating: state => {
    //     return !Array.isArray(state.movies.length) ? state.movies.movie_with_avg_rating[0].aggregate : null;
    // },
    // actors: state => {
    //     return !Array.isArray(state.movies.length) ? state.movies.staffs.filter(staff => staff.pivot.is_actor) : null;
    // },
    // crews: state => {
    //     return !Array.isArray(state.movies.length) ? state.movies.staffs.filter(staff => staff.pivot.is_crew) : null;
    // },
}

const mutations = {
    setMovies (state, movies) {
        state.movies = movies;
    },
    setIsFavFilter (state, favorite) {
        state.isFavFilter = favorite;
    },
    setIsWatchedFilter (state, watched) {
        state.isWatchedFilter = watched;
    },
    setApiStatus (state, status) {
        state.apiStatus = status;
    }
}

const actions = {
    async getMovieById (context, { movieId, userId }) {
        context.commit('setApiStatus', null);
        const response = await axios.get('/api/movie', {
            params: {
                movieId: movieId,
                userId: userId
            }
        });
        if (response.status === OK) {
            context.commit('setApiStatus', true);
            return response.data;
        }
    },
    async search (context, freeword) {
        context.commit('setApiStatus', null);
        const response = await axios.get('/api/movie', {
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
