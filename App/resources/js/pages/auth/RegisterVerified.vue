<template>
    <div class="vue-contents">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card" v-if="isRegistered === 0">
                    <div class="card-header">サーバーと確認中...</div>

                    <div class="card-body">
                        <p>現在サーバーと確認中です。</p>
                        <p>
                            このままで少々お待ちください。
                        </p>
                    </div>
                </div>
                <div class="card" v-if="isRegistered === 1">
                    <div class="card-header">本登録完了</div>

                    <div class="card-body">
                        <p>この度は、ご登録いただき、誠にありがとうございます。</p>
                        <p>
                            ご本人様確認が完了しました。
                        </p>
                        <p>
                            ShareMovieをお楽しみください。
                        </p>
                    </div>
                </div>
                <div class="card" v-if="isRegistered === 2">
                    <div class="card-header">確認エラー</div>

                    <div class="card-body">
                        <p>
                            ご本人様の確認が取れませんでした。
                            以下フォームから仮登録時のメールアドレスを入力して、確認メールを再送してください。
                        </p>
                        <form class="form" @submit.prevent="resendVerifyMail">
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
    created () {
        this.verify();
    },
    computed: {
        isRegistered () {
            return this.$store.getters['auth/isRegistered'];
        }
    },
    methods: {
        verify: async function () {
            await this.$store.dispatch('auth/verify', this.$route.params.token);
        },
        resendVerifyMail: async function () {
            await this.$store.dispatch('auth/resendVerifyMail', this.email);

            this.$router.push('/pre-register');
        }
    }
}
</script>
