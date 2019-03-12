<template>
    <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <div class="nav-item home">
                    <RouterLink class="nav-link home" to="/">ShareMovie</RouterLink>
                </div>
                <SearchMovie />
                <div v-if="isLogin" class="nav-item user">
                    <div class="dropdown">
                        <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            {{ username }}
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                            <RouterLink class="dropdown-item" v-bind:to="{ name : 'UserDetail', params : { username: username, option: 'post' }}">
                                マイページ
                            </RouterLink>
                            <RouterLink class="dropdown-item" v-bind:to="{ name : 'UserSetUpAccount'}">
                                設定
                            </RouterLink>
                            <a class="dropdown-item" v-on:click="logout()">
                                ログアウト
                            </a>
                        </ul>
                    </div>
                </div>
                <div v-else class="nav-item user">
                    <div class="nav-item login">
                        <RouterLink class="nav-link login" v-bind:to="{ name : 'Login'}">ログイン</RouterLink>
                    </div>
                    <div class="nav-item register">
                        <RouterLink class="nav-link register" v-bind:to="{ name : 'Register'}">新規登録</RouterLink>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</template>
<script>
import SearchMovie from './../../components/movies/SearchMovie.vue'

export default {
    components: {
        SearchMovie,
    },
    data() {
        return {
            freeword: ''
        }
    },
    computed: {
        apiStatus() {
            return this.$store.state.auth.apiStatus;
        },
        isLogin () {
            return this.$store.getters['auth/check'];
        },
        username () {
            return this.$store.getters['auth/username'];
        },
        user () {
            return this.$store.getters['auth/user'];
        }
    },
    methods: {
        async logout () {
            await this.$store.dispatch('auth/logout');

            if (this.apiStatus) {
                this.$router.push('/login');
            }
        },
        searchMovie: function () {
            if (this.freeword !== '') {
                // await this.$store.dispatch('movie/search', this.freeword);
                this.$router.push({ name: 'MovieSearchResult', query: {freeword: this.freeword}});
            }
        },
        async getUserPage () {
            this.$router.push('/user/' + this.username);
        }
    }
}
</script>
