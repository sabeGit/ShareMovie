<template>
    <div class="watched-action">
        <span class="fa fa-eye watched action" v-bind:class="{ active: watchedData }" v-on:click="doWatchedAction()">
        </span>
    </div>
</template>
<script>
import { ADD_WATCHED, REMOVE_WATCHED } from './../../util';

export default {
    props: {
        movie: {
            type: null,
            required: true,
        },
        watched: {
            type: Number,
            required: true,
        }
    },
    data () {
        return {
            watchedData: this.watched,
        }
    },
    methods: {
        doWatchedAction: async function() {
            this.watchedData = !this.watchedData;
            const result = await this.$store.dispatch('user/editWatchedMovie', { watched: this.watchedData, movie: this.movie });
            if (result && this.watchedData) {
                this.flash(ADD_WATCHED, 'success', { timeout: 5000 });
            } else if (result && !this.watchedData) {
                this.flash(REMOVE_WATCHED, 'info', { timeout: 5000 });
            }
        },
    }
}
</script>
