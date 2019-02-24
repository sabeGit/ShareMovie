<template>
    <div class="favorite-action">
        <a href="#" class="fa fa-heart favorite" v-bind:class="{ active: favorite }" v-on:click="doFavoriteAction()">
            <!-- <span class="fa fa-heart" v-bind:class="{ active: favorite }" aria-hidden="true"></span> -->
        </a>
        <!-- <div class="balloon favorite">
            お気に入り
        </div> -->
    </div>
</template>
<script>
export default {
    props: {
        movie: {
            type: null,
            required: true,
        }
    },
    computed: {
        favorite () {
            return this.movie.users[0].pivot.favorite;
        }
    },
    methods: {
        doFavoriteAction: async function() {
            await this.$store.dispatch('user/editFavoriteMovie', { favorite: !this.favorite, movie: this.movie });
        },
    }
}
</script>
