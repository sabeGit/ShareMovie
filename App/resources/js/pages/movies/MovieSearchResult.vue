<template>
    <div class="vue-contents">
        <SearchMovieList />
    </div>
</template>
<script>
import SearchMovieList from './../../components/movies/SearchMovieList.vue'

export default {
    components: {
        SearchMovieList
    },
    created() {
        this.getMovieList();
    },
    props: {
        freeword: {
            type: String,
            required: true,
        }
    },
    watch: {
        '$route' (to, from) {
            this.getMovieList(to.params.freeword);
        }
    },
    methods: {
        getMovieList: async function() {
            await this.$store.commit('movie/setMovies', null);
            await this.$store.dispatch('movie/search', this.freeword);
        },
    }
}
</script>
