<template>
    <div class="post-action">
        <textarea placeholder="コメントする" rows="5" class="form-control post" v-model="content"></textarea>
        <button type="submit" class="btn btn-primary post" v-on:click="postContent()" v-bind:disabled="isPush">コメント</button>
    </div>
</template>
<script>
import { POST_COMMENT } from './../../util';

export default {
    props: {
        movie: {
            type: null,
            required: true,
        },
    },
    data () {
        return {
            content: '',
            isPush: false,
        }
    },
    methods: {
        postContent: async function() {
            this.isPush = true;
            if (this.content !== '') {
                const result = await this.$store.dispatch('post/postContent', { content: this.content, movie: this.movie });
                if (result) {
                    this.content = '';
                    this.flash(POST_COMMENT, 'success', { timeout: 5000 });
                }
            }
            this.isPush = false;
        },
    }
}
</script>
