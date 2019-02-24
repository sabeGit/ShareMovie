<template>
    <div class="movie-list col-md-8">
        <div v-for="movie in movieList" class="movie-item">
            <div class="poster">
                <img class="poster-img" v-bind:src="'https://image.tmdb.org/t/p/w500/' + movie.poster_path" alt="Sample">
            </div>
            <div class="movie-content">
                <div class="movie-header">
                    <h2 class="movie-title">{{ movie.title }}</h2>
                </div>
                <div class="movie-body">
                    <p class="movie-overview" style="-webkit-box-orient: vertical;">{{ movie.overview }}</p>
                </div>
                <div class="movie-footer">
                    <form>
                        <WatchedAction :movie="movie"></WatchedAction>
                        <RateAction :movie="movie" :isEditable="false"></RateAction>
                        <FavAction :movie="movie"></FavAction>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import RateAction from './../../components/movies/RateAction.vue'
import WatchedAction from './../../components/movies/WatchedAction.vue'
import FavAction from './../../components/movies/FavAction.vue'

export default {
    components: {
        RateAction,
        WatchedAction,
        FavAction,
    },
    computed: {
        movieList () {
            return this.$store.getters['movie/filteredMovies'];
        }
    },
}
</script>
