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
            <!-- <div class="poster">
                <img class="poster-img" v-bind:src="post.movie.poster_full_path" alt="Sample">
            </div>
            <div class="post-content">
                <div class="post-header">
                    <RouterLink class="post-movie-title" v-bind:to="{ name : 'MovieDetail', params : { id: post.movie.id }}">{{ post.movie.title }}</RouterLink>
                </div>
                <div class="post-body">
                    <p class="post-content" style="-webkit-box-orient: vertical;">{{ post.content }}</p>
                </div>
            </div> -->
        </div>
    </div>
</template>
<script>

export default {
    props: {
        isEditable: {
            type: Boolean,
            required: true,
        }
    },
    computed: {
        posts () {
            return this.$store.getters['post/posts'];
        }
    },
}
</script>
