<template>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">パスワード再設定</div>
                <div class="card-body">
                    <form class="form" @submit.prevent="resetPassword">
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">新しいパスワード</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" v-model="resetPasswordForm.password" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">新しいパスワード（確認）</label>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" v-model="resetPasswordForm.password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary" v-bind:disabled="isPush">
                                    パスワードを変更
                                </button>
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
    data () {
        return {
            resetPasswordForm: {
                password: '',
                password_confirmation: '',
            },
            isPush: false,
        }
    },
    created () {
        this.verifyPasswordResetMail();
    },
    methods: {
        verifyPasswordResetMail: async function () {
            await this.$store.dispatch('auth/verifyPasswordResetMail', this.$route.params.token);
        },
        resetPassword: async function () {
            this.isPush = true;
            await this.$store.dispatch('auth/resetPassword', this.resetPasswordForm);
        }
    }
}
</script>
