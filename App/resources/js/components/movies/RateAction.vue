<template>
    <div class="rate-action" v-bind:class="{ editable: isEditable }">
        <p class="rating-label">{{ ratingLabel }}</p>
        <span class="star-rating" v-bind:class="{ editable: isEditable }">
            <input type="radio" name="rating" value="1" v-on:click="doRateAction('1')" v-bind:checked="one" v-bind:disabled="!isEditable"><i></i>
            <input type="radio" name="rating" value="2" v-on:click="doRateAction('2')" v-bind:checked="two" v-bind:disabled="!isEditable"><i></i>
            <input type="radio" name="rating" value="3" v-on:click="doRateAction('3')" v-bind:checked="three" v-bind:disabled="!isEditable"><i></i>
            <input type="radio" name="rating" value="4" v-on:click="doRateAction('4')" v-bind:checked="four" v-bind:disabled="!isEditable"><i></i>
            <input type="radio" name="rating" value="5" v-on:click="doRateAction('5')" v-bind:checked="five" v-bind:disabled="!isEditable"><i></i>
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
        isEditable: {
            type: Boolean,
            required: true,
        }
    },
    data () {
        return {
            one: false,
            two: false,
            three: false,
            four: false,
            five: false,
        }
    },
    computed: {
        rating () {
            return this.movie.users[0].pivot.rating;
        },
        ratingLabel () {
            return this.isEditable ? 'あなたの評価：' : 'ユーザーの評価：';
        }
    },
    created () {
        if (this.rating === 1) {
            this.one = true;
        } else if (this.rating === 2) {
            this.two = true;
        } else if (this.rating === 3) {
            this.three = true;
        } else if (this.rating === 4) {
            this.four = true;
        } else if (this.rating === 5) {
            this.five = true;
        }
    },
    methods: {
        doRateAction: async function(rating) {
            await this.$store.dispatch('user/editMovieRating', { rating: rating, movie: this.movie });
        },
    }
}
</script>
