<template>
    <div class="home-container" v-if="movie">
        <div class="home-contents">
            <h1 class="app-name">ShareMovie</h1>
            <p class="app-description">お気に入りの映画を見つけよう</p>
            <SearchMovie />
        </div>
        <img class="poster-img home" v-bind:src="'https://image.tmdb.org/t/p/original' + movie.backdrop_path" alt="Sample">
    </div>
</template>
<script>
import SearchMovie from './../../components/movies/SearchMovie.vue'

export default {
    components: {
        SearchMovie,
    },
    computed: {
        movie () {
            return this.$store.getters['movie/movies'];
        }
    },
    created () {
        this.getPopularMovieFromTMDB();
    },
    methods: {
        getPopularMovieFromTMDB: async function () {
            await this.$store.dispatch('movie/getPopularMovieFromTMDB');
        }
    }
}
</script>
