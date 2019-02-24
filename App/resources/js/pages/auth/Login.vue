<template>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">ログイン</div>
                <div class="card-body">
                    <form class="form" @submit.prevent="login">
                        <div class="form-group row">
                            <label for="email" class="col-sm-4 col-form-label text-md-right">メールアドレス</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" v-model="loginForm.email" required autofocus>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">パスワード</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" v-model="loginForm.password" required>
                            </div>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" v-model="loginForm.remember">
                            <label class="form-check-label" for="remember">ログイン情報を保存する</label>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    ログイン
                                </button>
                                <RouterLink class="btn btn-link" v-bind:to="{ name : 'PasswordForgot' }">
                                    パスワードをお忘れですか？
                                </RouterLink>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            loginForm: {
                email: '',
                password: '',
                remember:false
            }
        }
    },
    computed: {
        apiStatus () {
            return this.$store.state.auth.apiStatus;
        },
        loginErrors () {
            return this.$store.state.auth.loginErrorMessages;
        }
    },
    methods: {
        login: async function () {
            // authストアのloginアクションを呼び出す
            await this.$store.dispatch('auth/login', this.loginForm);

            if (this.apiStatus) {
                this.$router.push('/');
            }
        }
    }
}
</script>
