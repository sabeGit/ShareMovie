<template>
    <div>
        <p>
            <input type="text" v-model="freeword">
            <button type="submit" v-on:click="searchMovie">送信</button>
        </p>
        <div class="container">
        <div class="row">
            <div v-for="movie in movies" class="col-sm-4 col-md-2 col-lg-2">
                    <div class="card">
                        <img class="card-img-top" v-bind:src="imgBaseURL + movie.poster_path">
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
</template>

<style>
.card-img-top {
    width: 100%;
    float: left;
    margin-right: 10px;
}

.description {
    overflow: auto;
}

img {
    box-shadow:2px 6px 16px 0 #232A40;
}

.card {
    margin-bottom: 10px;
}
</style>

<script>
    export default {
        data() {
            return {
                freeword: '',
                movies: [],
                imgBaseURL: 'https://image.tmdb.org/t/p/w500/'
            }
        },
        methods: {
            searchMovie: function() {
                window.axios.get('/api/movies?freeword=' + this.freeword)
                .then(response => {
                    this.movies = response.data
                })

            },

        }
    }
</script>
