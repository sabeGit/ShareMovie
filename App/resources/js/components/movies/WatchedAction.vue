<template>
    <div class="watched-action">
        <span class="fa fa-eye watched action" v-bind:class="{ active: watchedData }" v-on:click="doWatchedAction()">
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
            await this.$store.dispatch('user/editWatchedMovie', { watched: this.watchedData, movie: this.movie });
        },
    }
}
</script>
