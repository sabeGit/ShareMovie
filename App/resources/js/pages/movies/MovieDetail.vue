<template>
    <div class="vue-contents col-md-8">
        <div class="row movie-detail" v-if="movie">
            <div class="poster-img-area">
                <div class="card card-show movie-detail">
                    <img class="poster-img movie-detail" v-bind:src="'https://image.tmdb.org/t/p/w500/' + movie.poster_path" alt="Sample">
                </div>
            </div>
            <div class="movie-detail-area">
                <h1 class="movie-title movie-detail">
                    {{ movie.title }}
                </h1>
                <div class="rate-action read-only">
                    <p class="rating-label">平均評価：</p>
                    <RateAction :movie="movie" :rating="movie.avgRating" :isEditable="false"></RateAction>
                </div>
                <dl>
                    <dt>主演</dt>
                        <dd v-for="actor in actors">
                            <span style="font-weight: bold;">{{ actor.name }}</span>
                                <span v-if="actor !== actors.slice(-1)[0]">,</span>
                        </dd>
                    <dt>監督</dt>
                        <dd v-for="crew in crews">
                            <span style="font-weight: bold;">{{ crew.name }}</span>
                                <span v-if="crew !== crews.slice(-1)[0]">,</span>
                        </dd>
                </dl>
                <div class="movie-overview movie-detail">
                    {{ movie.overview }}
                </div>
                <!-- <div v-if="loginUser"> -->
                <WatchedAction :movie="movie" :watched="movie.watched"></WatchedAction>
                <div class="rate-action editable">
                    <p class="rating-label">あなたの評価：</p>
                    <RateAction :movie="movie" :rating="movie.rating" :isEditable="true"></RateAction>
                </div>
                <FavAction :movie="movie" :favorite="movie.favorite"></FavAction>
                <!-- <iframe width="560" height="315" src="https://www.youtube.com/embed/SUXWAEX2jlg" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe> -->
            </div>
        </div>
        <div class="post-section">
            <p class="post-count">{{ postsCount }}件のコメント</p>
            <PostAction :movie="movie"></PostAction>
            <PostList v-if="posts"></PostList>
        </div>
    </div>
</template>
<script>
import RateAction from './../../components/movies/RateAction.vue'
import WatchedAction from './../../components/movies/WatchedAction.vue'
import FavAction from './../../components/movies/FavAction.vue'
import PostAction from './../../components/posts/PostAction.vue'
import PostList from './../../components/posts/PostList.vue'

export default {
    components: {
        RateAction,
        WatchedAction,
        FavAction,
        PostAction,
        PostList
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
        actors () {
            return this.movie ? this.movie.credits.cast.slice(0, 3): null;
        },
        crews () {
            return this.movie ? this.movie.credits.crew.slice(0, 3) : null;
        },
        postsCount () {
            return this.$store.getters['post/postsCount'];
        },
        posts () {
            return this.$store.getters['post/posts'];
        }
    },
    methods: {
        getMovieDetail: async function() {
            this.movie = await this.$store.dispatch('movie/getMovieById', {
                movieId: this.$route.params.id,
                userId: this.loginUser ? this.loginUser.id : null,
            });
        },
    }
}
</script>
