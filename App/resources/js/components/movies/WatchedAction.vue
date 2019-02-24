<template>
    <div class="watched-action">
        <a href="#" class="fa fa-eye watched" v-bind:class="{ active: watched }" v-on:click="doWatchedAction()">
            <!-- <span class="fa fa-eye" v-bind:class="{ active: watched }" aria-hidden="true"></span> -->
        </a>
        <!-- <div class="balloon favorite">
            視聴済み
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
        watched () {
            return this.movie.users[0].pivot.watched;
        }
    },
    methods: {
        doWatchedAction: async function() {
            await this.$store.dispatch('user/editWatchedMovie', { watched: !this.watched, movie: this.movie });
        },
    }
}
</script>
