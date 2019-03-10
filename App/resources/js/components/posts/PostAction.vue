<template>
    <div class="post-action">
        <textarea placeholder="コメントする" rows="5" class="form-control post" v-model="content"></textarea>
        <button type="submit" class="btn btn-primary post" v-on:click="postContent()">コメント</button>
    </div>
</template>
<script>
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
                await this.$store.dispatch('post/postContent', { content: this.content, movie: this.movie });
            }
        },
    }
}
</script>
