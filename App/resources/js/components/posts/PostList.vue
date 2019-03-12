<template>
    <div class="post-list">
        <div v-for="post in posts" class="post-item">
            <div class="post-movie-info" v-if="post.movie">
                <RouterLink class="post-movie-title" v-bind:to="{ name : 'MovieDetail', params : { id: post.movie.id }}">{{ post.movie.title }}</RouterLink>
                <p class="post-movie-title-suffix">に対するコメント</p>
            </div>
            <RouterLink class="post-user-info-link-image" v-bind:to="{ name : 'UserDetail', params : { username: post.user.name } }">
                <img class="post-profile-image" v-bind:src="post.user.profile_image" v-if="post.user.profile_image"/>
                <img class="post-profile-image" v-bind:src="'/images/default-profile-icon.png'" v-else/>
            </RouterLink>
            <RouterLink class="post-user-info-link-name" v-bind:to="{ name : 'UserDetail', params : { username: post.user.name } }">
                <div class="post-username">{{ post.user.name }}</div>
            </RouterLink>
            <p class="post-at">{{ post.post_at }}</p>
            <p class="post-content">
                {{ post.content }}
            </p>
        </div>
    </div>
</template>
<script>

export default {
    computed: {
        posts () {
            return this.$store.getters['post/posts'];
        }
    },
}
</script>
