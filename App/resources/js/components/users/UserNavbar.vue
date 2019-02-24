<template>
<nav class="navbar navbar-expand-sm navbar-light bg-whitesmoke mt-3 mb-3 user-item-nav">
    <div class="collapse navbar-collapse justify-content-around">
        <ul class="navbar-nav">
            <li class="user-item favorite">
                <a href="#" class="favorite" v-on:click="getFavMovies()">
                    <span class="fa fa-heart" aria-hidden="true"></span>
                    <span class="favorite-count">{{ favMoviesCount }}</span>
                </a>
            </li>
        </ul>
        <ul class="navbar-nav">
            <li class="user-item watched" v-on:click="getWatchedMovies()">
                <a href="#" class="watched">
                    <span class="fa fa-eye" aria-hidden="true"></span>
                    <span class="watched-count">{{ watchedMoviesCount }}</span>
                </a>
            </li>
        </ul>
    </div>
</nav>
</template>

<script>
export default {
    data() {
        return {
            favorite: false,
            watched: false,
        }
    },
    computed: {
        favMoviesCount () {
            return this.$store.getters['movie/favMoviesCount'];
        },
        watchedMoviesCount () {
            return this.$store.getters['movie/watchedMoviesCount'];
        },
    },
    methods: {
        getFavMovies: function() {
            this.favorite = true;
            this.watched = false;

            this.$store.commit('movie/setIsFavFilter', this.favorite);
            this.$store.commit('movie/setIsWatchedFilter', this.watched);
        },
        getWatchedMovies: function() {
            this.favorite = false;
            this.watched = true;

            this.$store.commit('movie/setIsFavFilter', this.favorite);
            this.$store.commit('movie/setIsWatchedFilter', this.watched);
        },
        getMovieList: function(item) {
            var movieList = null;
            if (item === 'favorite') {
                this.favorite = true;
                this.watched = false;
                // movieList = this.$store.getters['movie/favMovies'];
            } else if (item === 'watched') {
                this.watched = true;
                // movieList = this.$store.getters['movie/watchedMovies'];
            }
            this.$store.commit('movie/setIsFavList', this.favorite);
            this.$store.commit('movie/setIsWatchedList', this.watched);
            // this.$emit('setMovieList', movieList);
        }
    }
}
</script>
