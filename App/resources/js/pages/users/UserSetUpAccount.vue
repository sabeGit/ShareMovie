<template>
    <div class="vue-contents">
        <div class="row">
            <UserSetUpSidebar />
            <div class="col-sm-9 col-sm-offset-3">
                <div class="setting-contents">
                    <div class="setting-title-section">
                        <span>アカウント</span>
                    </div>
                    <form v-on:submit.prevent="setUpAccount" enctype="multipart/form-data">
                        <div class="setting-profile-images-section">
                            <img v-show="accountForm.uploadedImage" :src="accountForm.uploadedImage" class="profile-image"/>
                            <input type="file" v-on:change="onFileChange" class="file-upload">
                        </div>
                        <div class="setting-username-section">
                            <label for="name">ユーザネーム</label>
                            <input id="name" type="text" class="setting-username" name="name" v-model="accountForm.username">
                        </div>
                        <button type="submit" class="btn btn-primary">
                            更新する
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import UserSetUpSidebar from './../../components/users/UserSetUpSidebar.vue'

export default {
    components: {
        UserSetUpSidebar
    },
    data () {
        return {
            accountForm: {
                uploadedImage: '',
                username: '',
            }
        }
    },
    created () {
        this.getUserName();
    },
    methods: {
        getUserName: function () {
            this.accountForm.username = this.$store.getters['auth/username'];
        },
        onFileChange: function (e) {
            let files = e.target.files || e.dataTransfer.files;
            this.createImage(files[0]);
        },
        // アップロードした画像を表示
        createImage: function (file) {
            let reader = new FileReader();
            reader.onload = (e) => {
                this.accountForm.uploadedImage = e.target.result;
            };
            reader.readAsDataURL(file);
        },
        setUpAccount: async function () {
            await this.$store.dispatch('user/setUpAccount', this.accountForm);
        }
    },
}
</script>
