<template>
    <div class="search-section">
        <input type="text" class="form-control search" name="freeword" placeholder="検索" v-model="freeword">
            <span class="input-group-btn">
                <button type="submit" class="btn btn-default" v-on:click="searchMovie()"><span class="fa fa-search" aria-hidden="true"></span></button>
            </span>
    </div>
</template>
<script>
export default {
    data() {
        return {
            freeword: ''
        }
    },
    methods: {
        searchMovie: function () {
            if (this.freeword !== '') {
                // await this.$store.dispatch('movie/search', this.freeword);
                this.$router.push({ name: 'MovieSearchResult', query: {freeword: this.freeword}});
            }
        },
    }
}
</script>
