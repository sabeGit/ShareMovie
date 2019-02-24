<template>
    <div class="show-actions">
    <ul class="action-list">
        <li class="action-item favorite">
            <a href="#" class="action favorite" v-bind:class="{ active: favorite }" v-on:click="switchActions('favorite')">
                <span class="fa fa-heart" v-bind:class="{ active: favorite }" aria-hidden="true"></span>
            </a>
        </li>
        <li class="action-item watched">
            <a href="#" class="action watched" v-bind:class="{ active: watched }" v-on:click="switchActions('watched')">
                <span class="fa fa-eye" v-bind:class="{ active: watched }" aria-hidden="true"></span>
            </a>
        </li>
        <li class="action-item review">
            <a href="#" class="action review" v-on:click="openModal()">
                <span class="fa fa-pencil" aria-hidden="true"></span>
            </a>
        </li>
    </ul>
    <!-- モーダルを設置 -->
    <review-modal v-if="isOpen" v-on:close="closeModal" v-on:post="createPost"></review-modal>
    </div>
</template>

<script>
import Modal from './ReviewModal'
export default {
    components: {
        Modal
    },
    props: {
        movie: {
            type: String,
            required: true,
        }
    },
    data() {
        return {
            isOpen: false,
            watched: false,
            favorite: false,
            movieObj: [],
        }
    },
    created() {
        this.movieObj = JSON.parse(this.movie);
        // this.getMovieListByUser().then((res) => {
        //     this.watched = res.watched;
        //     this.favorite    = res.favorite;
        // });
        this.getMovieListByUser();
    },
    methods: {
        openModal: function() {
            this.isOpen = true;
        },
        closeModal: function() {
            this.isOpen = false;
        },
        createPost: function(reviewInfo) {
            window.axios.post('/api/posts',{
                rating: reviewInfo.rating,
                content: reviewInfo.content,
                movieId: this.movieObj.id,
            }).then((res)=>{
                if (res.status !== 201) { console.log(res); }
            });
        },
        getMovieListByUser: async function() {
            // const res = await window.axios.get('/api/users/movie_list?movie_id=' + this.movieObj.id);
            // if (res.status !== 200) { console.log(res); }
            // return res.data;
            window.axios.get('/api/users/movie?movie_id=' + this.movieObj.id).then((res) =>{
                if (res.status !== 200) { console.log(res); }
                this.watched = res.data.watched;
                this.favorite = res.data.favorite;
            });
        },
        switchActions: function(item) {
            if (item === 'favorite') {
                this.favorite = !this.favorite;
            } else if (item === 'watched') {
                this.watched = !this.watched;
            }
            const res = window.axios.post('/api/users/movie',{
                watched: this.watched,
                favorite: this.favorite,
                movie: this.movie,
            })
            console.log(res)
            //this.getMovieListByUser();
        }
    }
}
</script>
