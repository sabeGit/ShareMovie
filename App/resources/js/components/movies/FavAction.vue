<template>
    <div class="favorite-action">
        <span class="fa fa-heart favorite action" v-bind:class="{ active: favoriteData }" v-on:click="doFavoriteAction()">
        </span>
    </div>
</template>
<script>
import { ADD_FAVORITE, REMOVE_FAVORITE } from './../../util';

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
            const result = await this.$store.dispatch('user/editFavoriteMovie', { favorite: this.favoriteData, movie: this.movie });
            if (result && this.favoriteData) {
                this.flash(ADD_FAVORITE, 'success', { timeout: 5000 });
            } else if (result && !this.favoriteData) {
                this.flash(REMOVE_FAVORITE, 'info', { timeout: 5000 });
            }
        },
    }
}
</script>
