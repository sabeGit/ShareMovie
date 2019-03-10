<template>
    <div class="favorite-action">
        <span class="fa fa-heart favorite action" v-bind:class="{ active: favoriteData }" v-on:click="doFavoriteAction()">
        </span>
    </div>
</template>
<script>
export default {
    props: {
        movie: {
            type: null,
            required: true,
        },
        favorite: {
            type: Number,
            required: true,
        }
    },
    data () {
        return {
            favoriteData: this.favorite,
        }
    },
    methods: {
        doFavoriteAction: async function() {
            this.favoriteData = !this.favoriteData;
            await this.$store.dispatch('user/editFavoriteMovie', { favorite: this.favoriteData, movie: this.movie });
        },
    }
}
</script>
