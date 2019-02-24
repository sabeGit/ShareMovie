<template>
    <transition name="modal">
        <div class="modal-mask">
            <div class="modal-wrapper" @click.self="doCloseEmit()">
                <div class="modal-container">
                    <div class="modal-body">
                        <!-- <form> -->
                            <ul>
                                <li class="content">
                                    <header class="header header--section">
                                        <label>評価</label>
                                    </header>
                                    <span class="star-rating">
                                        <input type="radio" name="rating" value="1" v-model="reviewInfo.rating"><i></i>
                                        <input type="radio" name="rating" value="2" v-model="reviewInfo.rating"><i></i>
                                        <input type="radio" name="rating" value="3" v-model="reviewInfo.rating"><i></i>
                                        <input type="radio" name="rating" value="4" v-model="reviewInfo.rating"><i></i>
                                        <input type="radio" name="rating" value="5" v-model="reviewInfo.rating"><i></i>
                                    </span>
                                </li>
                                <li class="content">
                                    <header class="header header--section">
                                        <label for="content">感想/メモなど</label>
                                    </header>
                                    <textarea id="content" name="content" class="form-control content" rows="4" v-model="reviewInfo.content"></textarea>
                                </li>
                            </ul>
                            <div class="modal-footer">
                                <button v-on:click="doCloseEmit()">閉じる</button>
                                <button v-on:click="doPostEmit()">投稿</button>
                            </div><!-- .modal-footer -->
                        <!-- </form> -->
                    </div><!-- .modal-body -->
                </div><!-- .modal-container -->
            </div><!-- .modal-wrapper -->
        </div><!-- .modal-mask -->
    </transition>
</template>

<script>
export default {
    data() {
        return {
            reviewInfo: {
                rating: '',
                content: '',
            },
        }
    },
    methods: {
        /**
         * モーダルを閉じます。
         */
        doCloseEmit: function() {
            this.$emit('close');
        },

        /**
         * レビュー登録
         */
        doPostEmit: function() {
            this.$emit('post', this.reviewInfo);
        },
    },
}
$('#mode input[type=radio]').change( function() {
    console.log(this.value);
});
</script>

<style scoped>
.modal-mask {
    position: fixed;
    z-index: 9998;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, .5);
    display: table;
    transition: opacity .3s ease;
}

.modal-wrapper {
    display: table-cell;
    vertical-align: middle;
}

.modal-container {
    width: 50%;
    margin: 0px auto;
    padding: 20px 30px;
    background-color: #fff;
    border-radius: 2px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
    transition: all .3s ease;
    font-family: Helvetica, Arial, sans-serif;
}

.modal-header h3 {
    margin-top: 0;
    color: #42b983;
}

.modal-body {
    margin: 20px 0;
}

.modal-default-button {
    float: right;
}

.modal-enter {
    opacity: 0;
}

.modal-leave-active {
    opacity: 0;
}

.modal-enter .modal-container,
.modal-leave-active .modal-container {
    -webkit-transform: scale(1.1);
    transform: scale(1.1);
}

ul li {
    list-style: none;
}

li.watch > header > label {
    margin-right: 10px;
    display: block;
    font-weight: bold;
}

li.content > header > label {
    margin-right: 10px;
    font-weight: bold;
    margin-top: 20px;
}

li.watch > div {
    margin-bottom: 20px;
}

.header--section {
    margin-bottom: 1em;
    border-bottom: 3px solid #d8dbe3;
}

.star-rating {
    font-size: 0;
    white-space: nowrap;
    display: inline-block;
    width: 150px;
    height: 30px;
    overflow: hidden;
    position: relative;
    background: url('data:image/svg+xml;utf-8,<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="20px" height="20px" viewBox="0 0 20 20" enable-background="new 0 0 20 20" xml:space="preserve"><polygon fill="#DDDDDD" points="10,0 13.09,6.583 20,7.639 15,12.764 16.18,20 10,16.583 3.82,20 5,12.764 0,7.639 6.91,6.583 "/></svg>');
    background-size: contain;
}

.star-rating i {
    opacity: 0;
    position: absolute;
    left: 0;
    top: 0;
    height: 100%;
    width: 20%;
    z-index: 1;
    background: url('data:image/svg+xml;utf-8,<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="20px" height="20px" viewBox="0 0 20 20" enable-background="new 0 0 20 20" xml:space="preserve"><polygon fill="#FFDF88" points="10,0 13.09,6.583 20,7.639 15,12.764 16.18,20 10,16.583 3.82,20 5,12.764 0,7.639 6.91,6.583 "/></svg>');
    background-size: contain;
}

.star-rating input {
    -moz-appearance: none;
    -webkit-appearance: none;
    opacity: 0;
    display: inline-block;
    width: 20%;
    height: 100%;
    margin: 0;
    padding: 0;
    z-index: 2;
    position: relative;
}

.star-rating input:hover + i,
.star-rating input:checked + i {
    opacity: 1;
}

.star-rating i ~ i {
    width: 40%;
}

.star-rating i ~ i ~ i {
    width: 60%;
}

.star-rating i ~ i ~ i ~ i {
    width: 80%;
}

.star-rating i ~ i ~ i ~ i ~ i {
    width: 100%;
}

.choice {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    text-align: center;
    padding: 20px;
    display: block;
}

</style>
