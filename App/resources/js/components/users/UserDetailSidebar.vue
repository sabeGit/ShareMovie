<template>
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
</template>
<script>
export default {
    data () {
        return {
            selectItem: ''
        }
    },
    computed: {
        username () {
            return this.$store.getters['user/username'];
        }
    },
    watch: {
        '$route' (path) {
            this.selectItem = path.params.option;
        }
    },
}
</script>
