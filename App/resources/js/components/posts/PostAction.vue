<template>
    <div class="post-action">
        <textarea placeholder="コメントする" rows="5" class="form-control post" v-model="content"></textarea>
        <button type="submit" class="btn btn-primary post" v-on:click="postContent()">コメント</button>
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
        }
    },
    methods: {
        postContent: async function() {
            if (this.content !== '') {
                const result = await this.$store.dispatch('post/postContent', { content: this.content, movie: this.movie });
                if (result) {
                    this.flash(POST_COMMENT, 'success', { timeout: 5000 });
                }
            }
        },
    }
}
</script>
