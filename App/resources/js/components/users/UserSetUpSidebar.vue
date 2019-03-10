<template>
    <div class="sidebar col-sm-3 hidden-xs">
        <div class="list-group">
            <RouterLink :to="{ name : 'UserSetUpAccount' }" class="list-group-item" v-bind:class="{ active: selectItem === 'account' }">アカウント</RouterLink>
            <RouterLink to="#" class="list-group-item" v-bind:class="{ active: selectItem === 'mail' }">メールアドレス</RouterLink>
            <RouterLink to="#" class="list-group-item" v-bind:class="{ active: selectItem === 'password' }">パスワード</RouterLink>
        </div>
    </div>
</template>
<script>
export default {
    data () {
        return {
            selectItem: 'account'
        }
    },
    watch: {
        '$route' (path) {
            console.log(path.hash)
        }
    },
}
</script>
