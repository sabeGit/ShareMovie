<template>
    <div class="vue-contents">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">新規登録</div>
                    <div class="card-body">
                        <form class="form" v-on:submit.prevent="register">
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">ユーザネーム</label>
                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name" v-model="registerForm.name" required autofocus>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">メールアドレス</label>
                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email" v-model="registerForm.email" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">パスワード</label>
                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password" v-model="registerForm.password" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">パスワード（確認）</label>
                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" v-model="registerForm.password_confirmation" required>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        新規登録
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
            registerForm: {
                name: '',
                email: '',
                password: '',
                password_confirmation: '',
            }
        }
    },
    computed: {
        registerErrors () {
            return this.$store.state.auth.registerErrorMessages;
        },
        apiStatus () {
            return this.$store.getters['auth/apiStatus'];
        }
    },
    methods: {
        async register () {
            // authストアのregisterアクションの呼び出し
            await this.$store.dispatch('auth/register', this.registerForm);
            if (this.apiStatus) {
                this.$router.push({ name: 'PreRegister' });
            }
        }
    }
}
</script>
