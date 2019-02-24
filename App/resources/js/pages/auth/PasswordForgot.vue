<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">パスワード再設定</div>
                    <div class="card-body">
                        <p>
                            以下フォームから仮登録時のメールアドレスを入力して、パスワード再設定用メールを送信してください。
                        </p>
                        <form class="form" @submit.prevent="sendPasswordResetMail">
                            <div class="form-group row">
                                <label for="email" class="col-sm-4 col-form-label text-md-right">メールアドレス</label>
                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email" v-model="email" required autofocus>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        送信
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            email: '',
        }
    },
    methods: {
        sendPasswordResetMail: async function () {
            await this.$store.dispatch('auth/sendPasswordResetMail', this.email);
            this.$router.push('/password/sent');
        }
    }
}
</script>
