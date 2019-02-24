<template>
    <div class="container">
        <div class="profile-img">

            <img v-bind:src="'/images/default-profile-icon.jpg'" />
        </div>
        <div class="username">
            {{ username }}
        </div>
        <UserNavbar />
        <MovieList :isEditable="isEditable"></MovieList>
        <!-- <UserNavbar v-on:setMovieList="setMovieList"></UserNavbar> -->
        <!-- <MovieList :movieList="movieList"></MovieList> -->
    </div>
</template>
<script>
import UserNavbar from './../../components/users/UserNavbar.vue'
import MovieList from './../../components/movies/MovieList.vue'

export default {
    components: {
        UserNavbar,
        MovieList
    },
    created () {
        this.checkUser();
        this.getMovieList();
    },
    data() {
        return {
            movieList: null,
            isEditable: true,
        }
    },
    computed: {
        username () {
            return this.$store.getters['user/username'];
        },
        user () {
            return this.$store.getters['user/user'];
        },
        loginUser () {
            return this.$store.getters['auth/loginUser'];
        }
    },
    methods: {
        checkUser: async function() {
            await this.$store.dispatch('user/setUser', this.$route.params.username);
            if (this.loginUser && this.user && this.user.id === this.loginUser.id) {
                this.isEditable = true;
            } else {
                this.isEditable = false;
            }
        },
        getMovieList: async function() {
            await this.$store.dispatch('user/getAllAttachedMovies', this.$route.params.username);
        },
    }
}
</script>
