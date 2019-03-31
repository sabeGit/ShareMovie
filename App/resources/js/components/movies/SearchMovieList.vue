<template>
    <div class="movie-list">
        <p>検索結果：{{ searchResultCount }}件</p>
        <div v-for="movie in movieList" class="movie-item">
            <div class="poster">
                <img class="poster-img" v-bind:src="'https://image.tmdb.org/t/p/w500/' + movie.poster_path" alt="Sample">
            </div>
            <div class="movie-content">
                <div class="movie-header">
                    <RouterLink class="movie-title" v-bind:to="{ name : 'MovieDetail', params : { id: movie.id }}">{{ movie.title }}</RouterLink>
                    <div class="avg-rating-section">
                        <div class="rate-action read-only">
                            <p class="rating-label">平均評価：</p>
                            <RateAction :movie="movie" :rating="movie.avgRating" :isEditable="false"></RateAction>
                        </div>
                    </div>
                </div>
                <div class="movie-body">
                    <p class="movie-overview" style="-webkit-box-orient: vertical;">{{ movie.overview }}</p>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import RateAction from './../../components/movies/RateAction.vue'
export default {
    components: {
        RateAction
    },
    computed: {
        movieList () {
            return this.$store.getters['movie/movies'];
        },
        searchResultCount () {
            return this.$store.getters['movie/moviesCount'];
        }
    },
}
</script>
