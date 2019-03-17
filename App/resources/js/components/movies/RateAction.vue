<template>
    <span class="star-rating" v-bind:class="{ editable: isEditable, 'read-only': !isEditable }">
        <i class="fa" v-bind:class="{ 'fa-star': ratingData >= 1, 'fa-star-o': ratingData < 1}" v-on:click="doRateAction(1)"></i>
        <i class="fa" v-bind:class="{ 'fa-star': ratingData >= 2, 'fa-star-o': ratingData < 2}" v-on:click="doRateAction(2)"></i>
        <i class="fa" v-bind:class="{ 'fa-star': ratingData >= 3, 'fa-star-o': ratingData < 3}" v-on:click="doRateAction(3)"></i>
        <i class="fa" v-bind:class="{ 'fa-star': ratingData >= 4, 'fa-star-o': ratingData < 4}" v-on:click="doRateAction(4)"></i>
        <i class="fa" v-bind:class="{ 'fa-star': ratingData >= 5, 'fa-star-o': ratingData < 5}" v-on:click="doRateAction(5)"></i>
    </span>
</template>
<script>
import { UPDATE_RATING } from './../../util';

export default {
    props: {
        movie: {
            type: null,
            required: true,
        },
        rating: {
            type: Number,
            required: true,
        },
        isEditable: {
            type: Boolean,
            required: true,
        }
    },
    data () {
        return {
            ratingData: this.rating,
            ratingLabel: this.isEditable ? 'あなたの評価：' : 'ユーザーの評価：',
        }
    },
    methods: {
        doRateAction: async function(ratingArg) {
            if (this.isEditable) {
                this.ratingData = ratingArg;
                const result = await this.$store.dispatch('user/editMovieRating', { rating: this.ratingData, movie: this.movie });
                if (result) {
                    this.flash(UPDATE_RATING, 'success', { timeout: 5000 });
                }
            }
        },
    }
}
</script>
