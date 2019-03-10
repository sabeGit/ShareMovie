<template>
    <div class="vue-contents">
        <div class="row">
            <div class="col-sm-3 hidden-xs">
                <div class="profile-img">
                    <img class="profile-image" v-bind:src="profileImage" v-if="profileImage"/>
                    <img class="profile-image" v-bind:src="'/images/default-profile-icon.png'" v-else/>
                </div>
                <div class="username">{{ username }}</div>
                <div class="sidebar">
                    <div class="list-group">
                        <RouterLink :to="{ name: 'UserDetail', params: { username: username, option: 'post' }}" class="list-group-item post" v-bind:class="{ active: selectItem === 'post' }">
                            コメント
                        </RouterLink>
                        <RouterLink :to="{ name: 'UserDetail', params: { username: username, option: 'rating' }}" class="list-group-item rating" v-bind:class="{ active: selectItem === 'rating' }">
                            レビュー
                        </RouterLink>
                        <RouterLink :to="{ name: 'UserDetail', params: { username: username, option: 'favorite' }}" class="list-group-item favorite" v-bind:class="{ active: selectItem === 'favorite' }">
                            お気に入り
                        </RouterLink>
                        <RouterLink :to="{ name: 'UserDetail', params: { username: username, option: 'watched' }}" class="list-group-item watched" v-bind:class="{ active: selectItem === 'watched' }">
                            視聴済み
                        </RouterLink>
                    </div>
                </div>
            </div>
            <!-- 「映画が取得されている」かつ「コメントリンク以外を選択している」場合、MovieListを表示 -->
            <MovieList :isEditable="isEditable" v-if="movies !== null && selectItem !== 'post'"></MovieList>
            <!-- 「コメントが取得されている」かつ「コメントリンクを選択している」場合、PostListを表示 -->
            <div class="col-md-8">
                <PostList :isEditable="isEditable" v-if="posts && selectItem === 'post'"></PostList>
            </div>
        </div>
    </div>
</template>
<script>
import UserDetailSidebar from './../../components/users/UserDetailSidebar.vue'
import UserNavBarbar from './../../components/users/UserNavbar.vue'
import MovieList from './../../components/movies/MovieList.vue'
import PostList from './../../components/posts/PostList.vue'

export default {
    components: {
        UserDetailSidebar,
        UserNavBarbar,
        MovieList,
        PostList
    },
    data () {
        return {
            isEditable: true,
            selectItem: '',
        }
    },
    created () {
        this.checkUser();
        this.selectItem = this.$route.params.option;
        if (this.selectItem === 'rating') {
            this.getRatingMovies();
        } else if (this.selectItem === 'favorite') {
            this.getFavMovies();
        } else if (this.selectItem === 'watched') {
            this.getWatchedMovies();
        }
    },
    computed: {
        profileImage () {
            return this.$store.getters['user/profileImage'];
        },
        username () {
            return this.$store.getters['user/username'];
        },
        user () {
            return this.$store.getters['user/user'];
        },
        loginUser () {
            return this.$store.getters['auth/loginUser'];
        },
        movies () {
            return this.$store.getters['movie/movies'];
        },
        posts () {
            return this.$store.getters['post/posts'];
        }
    },
    watch: {
        '$route' (path) {
            this.selectItem = path.params.option;
            if (this.selectItem === 'rating') {
                this.getRatingMovies();
            } else if (this.selectItem === 'favorite') {
                this.getFavMovies();
            } else if (this.selectItem === 'watched') {
                this.getWatchedMovies();
            }
        },
    },
    methods: {
        checkUser: async function () {
            await this.$store.dispatch('user/setUser', this.$route.params.username);
            if (this.loginUser && this.user && this.user.id === this.loginUser.id) {
                this.isEditable = true;
            } else {
                this.isEditable = false;
            }
        },
        getRatingMovies: async function () {
            this.$store.commit('movie/filterRating');
        },
        getFavMovies: async function () {
            this.$store.commit('movie/filterFavorite');
        },
        getWatchedMovies: async function () {
            this.$store.commit('movie/filterWatched');
        },
    }
}
</script>
