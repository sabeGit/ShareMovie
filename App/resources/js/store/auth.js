import { OK, CREATED, UNPROCESSABLE_ENTITY, LOGIN_ERROR_MSG } from '../util'

const state = {
    // ユーザー
    user: null,
    // ログインユーザー
    loginUser: null,
    // APIコール結果
    apiStatus: null,
    // ログイン状況
    isLoggedIn: !!localStorage.getItem('token'),
    // ユーザー登録状況  0:結果待ち, 1:登録成功, 2:登録失敗
    isRegistered: 0,
}

const getters = {
    // ユーザー取得
    user: state => state.user,
    // ログイン状況取得
    check: state => !! state.loginUser,
    // ログインユーザー取得
    loginUser: state => state.loginUser,
    // ログインユーザーネーム取得
    username: state => state.loginUser ? state.loginUser.name : '',
    // ユーザー登録状況取得
    isRegistered: state => state.isRegistered,
    // APIコール結果取得
    apiStatus: state => state.apiStatus,
}

const mutations = {
    setUser (state, user) {
        state.user = user;
    },
    setLoginUser (state, loginUser) {
        state.loginUser = loginUser;
    },
    setApiStatus (state, status) {
        state.apiStatus = status;
    },
    loginUser (state) {
        state.isLoggedIn = true;
    },
    logoutUser (state) {
        state.isLoggedIn = false;
    },
    registered (state, result) {
        state.isRegistered = result;
    }
}

const actions = {
    // 会員登録
    async register (context, data) {
        // 初期設定
        context.commit('setApiStatus', null);
        // ユーザー登録API
        const response = await axios.post('/api/register', data);
        // APIコール成功時
        if (response.status === CREATED) {
            context.commit('setApiStatus', true);
            return false;
        }
        // APIコール失敗
        context.commit('setApiStatus', false);
        // ステータスコードをerrorストアに格納
        context.commit('error/setCode', response.status, { root: true });
    },

    // ユーザー本登録
    async verify (context, token) {
        // 初期設定
        context.commit('setApiStatus', null);
        // ユーザー登録状況  0:結果待ち
        context.commit('registered', 0);
        // ユーザー本登録API @param:メールアドレストークン
        const response = await axios.get('/api/register/verify', {
            params: {
                token
            }
        });
        if (response.status === OK && response.data.result === 'success') {
            // ユーザー登録状況  1:登録成功
            context.commit('registered', 1);
            // アクセストークンをブラウザのローカルストレージに格納
            localStorage.setItem('token', response.data.access_token);
            // ログイン成功
            context.commit('loginUser');
            context.commit('setApiStatus', true);
            // ログインユーザーチェック
            await context.dispatch('currentUser');
        } else if (response.status === OK && response.data.result === 'error') {
            // ユーザー登録状況  2:登録失敗
            context.commit('registered', 2);
            context.commit('setApiStatus', false);
        } else {
            // ステータスコードをerrorストアに格納
            context.commit('error/setCode', response.status, { root: true });
        }
        return false;
    },

    // ログイン
    async login (context, data) {
        // 初期設定
        context.commit('setApiStatus', null);
        // ログインAPI
        const response = await axios.post('/api/login', data);
        if (response.status === OK) {
            // アクセストークンをブラウザのローカルストレージに格納
            localStorage.setItem('token', response.data.access_token);
            // ログイン成功
            context.commit('loginUser');
            context.commit('setApiStatus', true);
            // ログインユーザーチェック
            await context.dispatch('currentUser');
            return false;
        }
        // APIコール失敗
        context.commit('setApiStatus', false);
        // ステータスコードをerrorストアに格納
        context.commit('error/setCode', response.status, { root: true });
    },

    // ログアウト
    async logout (context) {
        // 初期設定
        context.commit('setApiStatus', null);
        // ログアウトAPI
        const response = await axios.post('/api/logout');
        if (response.status === OK) {
            // ローカルストレージのアクセストークンを削除
            localStorage.removeItem('token');
            // ログアウト成功
            context.commit('logoutUser');
            context.commit('setApiStatus', true);
            context.commit('setLoginUser', null);
            return false;
        }
        // APIコール失敗
        context.commit('setApiStatus', false);
        // ステータスコードをerrorストアに格納
        context.commit('error/setCode', response.status, { root: true });
    },

    // ログインユーザチェック
    async currentUser (context) {
        // 初期設定
        context.commit('setApiStatus', null);
        // ログインユーザー取得
        const response = await axios.get('/api/me');
        const loginUser = response.data || null;
        if (response.status === OK) {
            // ログインユーザー取得成功
            context.commit('setApiStatus', true);
            context.commit('setLoginUser', loginUser);
            return false;
        }
        // APIコール失敗
        context.commit('setApiStatus', false);
        // ステータスコードをerrorストアに格納
        context.commit('error/setCode', response.status, { root: true });
    },

    // 確認メール再送
    async resendVerifyMail (context, email) {
        // 初期設定
        context.commit('setApiStatus', null);
        // 確認メール再送API  @param:メールアドレス
        const response = await axios.get('/api/register/verify/resend', {
            params: {
                email
            }
        });
        if (response.status === OK) {
            // APIコール成功
            context.commit('setApiStatus', true);
            return false;
        }
        // APIコール失敗
        context.commit('setApiStatus', false);
        // ステータスコードをerrorストアに格納
        context.commit('error/setCode', response.status, { root: true });
    },

    // パスワードリセットメール送信
    async sendPasswordResetMail (context, email) {
        // 初期設定
        context.commit('setApiStatus', null);
        // パスワードリセットメール送信API  @param:メールアドレス
        const response = await axios.get('/api/password', {
            params: {
                email
            }
        });
        if (response.status === OK) {
            // APIコール成功
            context.commit('setApiStatus', true);
            return false;
        }
        // APIコール失敗
        context.commit('setApiStatus', false);
        // ステータスコードをerrorストアに格納
        context.commit('error/setCode', response.status, { root: true });
    },

    // パスワードのリセット
    async resetPassword (context, { data, token }) {
        // 初期設定
        context.commit('setApiStatus', null);
        // パスワードリセットAPI
        const response = await axios.post('/api/password/reset', {
            token                : token,
            password             : data.password,
            password_confirmation: data.password_confirmation,
        });
        if (response.status === OK) {
            // APIコール成功
            context.commit('setApiStatus', true);
            return false;
        }
        // APIコール失敗
        context.commit('setApiStatus', false);
        // ステータスコードをerrorストアに格納
        context.commit('error/setCode', response.status, { root: true });
    }

}

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions
}
