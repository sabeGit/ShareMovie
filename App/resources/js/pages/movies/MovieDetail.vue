<template>
    <!-- <div class="container" v-if="movie"> -->
    <div class="container" v-if="movie">
        <div class="row movie-detail">
            <div class="col-sm-4 col-md-3 col-lg-3">
                <div class="card card-show movie-detail">
                    <img class="poster-img movie-detail" v-bind:src="movie.poster_full_path" alt="Sample">
                </div>
            </div>
            <div class="col-sm-8 col-md-9 col-lg-9">
                <h1 class="movie-title movie-detail">
                    {{ movie.title }}
                </h1>
                <dl>
                    <dt>主演</dt>
                        <dd v-for="actor in actors">
                            <a href="#">{{ actor.name }}</a>
                                <span v-if="actor !== actors.slice(-1)[0]">,</span>
                        </dd>
                    <dt>監督</dt>
                        <dd v-for="crew in crews">
                            <a href="#">{{ crew.name }}</a>
                                <span v-if="crew !== crews.slice(-1)[0]">,</span>
                        </dd>
                </dl>
                <div class="movie-overview movie-detail">
                    {{ movie.overview }}
                </div>
                <div v-if="loginUser">
                    <WatchedAction :movie="movie"></WatchedAction>
                    <RateAction :movie="movie" :isEditable="true"></RateAction>
                    <FavAction :movie="movie"></FavAction>
                </div>
                <!-- <iframe width="560" height="315" src="https://www.youtube.com/embed/SUXWAEX2jlg" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe> -->
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
    created () {
        this.getMovieDetail();
    },
    data () {
        return {
            movie: null
        }
    },
    computed: {
        loginUser () {
            return this.$store.getters['auth/loginUser'];
        },
        avgRating () {
            return this.movie ? this.movie.movie_with_avg_rating[0].aggregate : null;
        },
        actors () {
            return this.movie ? this.movie.staffs.filter(staff => staff.pivot.is_actor) : null;
        },
        crews () {
            return this.movie ? this.movie.staffs.filter(staff => staff.pivot.is_crew) : null;
        },
    },
    methods: {
        getMovieDetail: async function() {
            this.movie = await this.$store.dispatch('movie/getMovieById', { movieId: this.$route.params.id, userId: this.loginUser ? this.loginUser.id : null });
        },
    }
}
</script>
