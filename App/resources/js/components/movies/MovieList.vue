<template>
    <div class="movie-list col-md-8">
        <div v-for="movie in movieList" class="movie-item">
            <div class="poster">
                <img class="poster-img" v-bind:src="movie.poster_full_path" alt="Sample">
            </div>
            <div class="movie-content">
                <div class="movie-header">
                    <RouterLink class="movie-title" v-bind:to="{ name : 'MovieDetail', params : { id: movie.id }}">{{ movie.title }}</RouterLink>
                    <form class="action-form">
                        <WatchedAction :movie="movie" :watched="movie.pivot.watched" v-show="isEditable"></WatchedAction>
                        <div class="rate-action" v-bind:class="{ editable: isEditable }">
                            <p class="rating-label" v-if="isEditable">あなたの評価：</p>
                            <p class="rating-label" v-else>ユーザーの評価：</p>
                            <RateAction :movie="movie" :rating="movie.pivot.rating"  :isEditable="isEditable"></RateAction>
                        </div>
                        <FavAction :movie="movie" :favorite="movie.pivot.favorite" v-show="isEditable"></FavAction>
                    </form>
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
import WatchedAction from './../../components/movies/WatchedAction.vue'
import FavAction from './../../components/movies/FavAction.vue'

export default {
    components: {
        RateAction,
        WatchedAction,
        FavAction
    },
    props: {
        isEditable: {
            type: Boolean,
            required: true,
        }
    },
    computed: {
        movieList () {
            return this.$store.getters['movie/filteredMovies'];
        }
    },
}
</script>
