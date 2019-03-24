<template>
    <div class="vue-contents col-md-12">
        <div class="row">
            <div class="col-sm-3 hidden-xs">
                <div class="profile-img">
                    <img class="profile-image" v-bind:src="profileImage" v-if="profileImage"/>
                    <img class="profile-image" v-bind:src="'/images/default-profile-icon.png'" v-else/>
                </div>
                <div class="username">{{ username }}</div>
                <div class="sidebar">
                    <div class="list-group">
                        <RouterLink v-bind:to="{ name: 'UserSetting', params: { option: 'account' }}" class="list-group-item account" v-bind:class="{ active: selectItem === 'account' }">
                            アカウント
                        </RouterLink>
                        <RouterLink v-bind:to="{ name: 'UserSetting', params: { option: 'mail' }}" class="list-group-item mail" v-bind:class="{ active: selectItem === 'mail' }">
                            メールアドレス
                        </RouterLink>
                        <RouterLink v-bind:to="{ name: 'UserSetting', params: { option: 'password' }}" class="list-group-item password" v-bind:class="{ active: selectItem === 'password' }">
                            パスワード
                        </RouterLink>
                    </div>
                </div>
            </div>
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
//import UserSetUpSidebar from './../../components/users/UserSetUpSidebar.vue'

export default {
    components: {

    },
    data () {
        return {
            selectItem: '',
            uploadedImage: '',
        }
    },
    computed: {
        profileImage () {
            return this.$store.getters['user/profileImage'];
        },
        username () {
            return this.$store.getters['user/username'];
        },
    },
    created () {
        this.selectItem = this.$route.params.option;
    },
    watch: {
        '$route' (path) {
            this.selectItem = path.params.option;
        },
    },
    methods: {
        onFileChange: function (e) {
            let files = e.target.files || e.dataTransfer.files;
            this.createImage(files[0]);
        },
        // アップロードした画像を表示
        createImage: function (file) {
            let reader = new FileReader();
            reader.onload = (e) => {
                this.uploadedImage = e.target.result;
            };
            reader.readAsDataURL(file);
        },
        setUpAccount: async function () {
            await this.$store.dispatch('user/editAccount', this.accountForm);
        }
    },
}
</script>
