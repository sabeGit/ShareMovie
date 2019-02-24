import { OK, CREATED, UNPROCESSABLE_ENTITY, LOGIN_ERROR_MSG } from '../util'

const state = {
    user: null,
    loginUser: null,
    apiStatus: null,
    loginErrorMessages: null,
    isLoggedIn: !!localStorage.getItem('token'),
    isRegistered: 0,    //0:結果待ち, 1:登録成功, 2:登録失敗
}

const getters = {
    user: state => state.user,
    check: state => !! state.loginUser,
    username: state => state.loginUser ? state.loginUser.name : '',
    loginUser: state => state.loginUser,
    isRegistered: state => state.isRegistered,
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
    setLoginErrorMessages (state, messages) {
        state.loginErrorMessages = messages;
    },
    setRegisterErrorMessages (state, messages) {
        state.setRegisterErrorMessages = messages;
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
        context.commit('setApiStatus', null);
        const response = await axios.post('/api/register', data);
        if (response.status === CREATED) {
            context.commit('setApiStatus', true);
            context.dispatch('currentUser');
            return false;
        }
        context.commit('setApiStatus', false);
        if (response.status === UNPROCESSABLE_ENTITY) {
            context.commit('setLoginErrorMessages', response.data.errors);
        } else {
            context.commit('error/setCode', response.status, { root: true });
        }
    },
    // ユーザー本登録
    async verify (context, token) {
        context.commit('setApiStatus', null);
        context.commit('registered', 0);
        const response = await axios.get('/api/register/verify', {
            params: {
                token
            }
        });
        if (response.status === OK && response.data.result === 'success') {
            localStorage.setItem('token', response.data.access_token);
            context.commit('loginUser');
            context.commit('registered', 1);
            context.commit('setApiStatus', true);
            context.dispatch('currentUser');
        } else if (response.status === OK && response.data.result === 'error') {
            context.commit('setApiStatus', false);
            context.commit('registered', 2);
        } else {
            context.commit('error/setCode', response.status, { root: true });
        }
        return false;
    },
    // ログイン
    async login (context, data) {
        context.commit('setApiStatus', null);
        const response = await axios.post('/api/login', data);
        console.log(response.data)
        if (response.status === OK) {
            localStorage.setItem('token', response.data.access_token);
            context.commit('loginUser');
            context.commit('setApiStatus', true);
            context.dispatch('currentUser');
            return false;
        }
        context.commit('setApiStatus', false);
        if (response.status === UNPROCESSABLE_ENTITY) {
            context.dispatch('noticeMessage/showFlashMessage', {text: LOGIN_ERROR_MSG, duration: 4000, mode: 'error'}, { root: true });
            context.commit('setLoginErrorMessages', response.data.errors);
        } else {
            context.commit('error/setCode', response.status, { root: true });
        }
    },
    // ログアウト
    async logout (context) {
        context.commit('setApiStatus', null);
        const response = await axios.post('/api/logout');
        if (response.status === OK) {
            localStorage.removeItem('token');
            context.commit('logoutUser');
            context.commit('setApiStatus', true);
            context.commit('setLoginUser', null);
            return false;
        }
        context.commit('setApiStatus', false);
        context.commit('error/setCode', response.status, { root: true });
    },
    // ログインユーザチェック
    async currentUser (context) {
        context.commit('setApiStatus', null);
        const response = await axios.get('/api/me');
        const loginUser = response.data || null;
        if (response.status === OK) {
            context.commit('setApiStatus', true);
            context.commit('setLoginUser', loginUser);
            return false;
        }
        context.commit('setApiStatus', false);
        context.commit('error/setCode', response.status, { root: true });
    },
    async resendVerifyMail (context, email) {
        context.commit('setApiStatus', null);
        const response = await axios.get('/api/register/verify/resend', {
            params: {
                email
            }
        });
        if (response.status === OK) {
            context.commit('setApiStatus', true);
            return false;
        }
        context.commit('setApiStatus', false);
        if (response.status === UNPROCESSABLE_ENTITY) {
            context.commit('setLoginErrorMessages', response.data.errors);
        } else {
            context.commit('error/setCode', response.status, { root: true });
        }
    },
    async sendPasswordResetMail (context, email) {
        context.commit('setApiStatus', null);
        const response = await axios.get('/api/password', {
            params: {
                email
            }
        });
        if (response.status === OK) {
            context.commit('setApiStatus', true);
            return false;
        }
        context.commit('setApiStatus', false);
        if (response.status === UNPROCESSABLE_ENTITY) {
            context.commit('setLoginErrorMessages', response.data.errors);
        } else {
            context.commit('error/setCode', response.status, { root: true });
        }
    },
    async verifyPasswordResetMail (context, token) {
        context.commit('setApiStatus', null);
        const response = await axios.get('/api/password/verify', {
            params: {
                token
            }
        });
        if (response.status === OK) {
            context.commit('setUser', response.data.user);
            context.commit('setApiStatus', true);
            return false;
        }
        context.commit('setApiStatus', false);
        if (response.status === UNPROCESSABLE_ENTITY) {
            context.commit('setLoginErrorMessages', response.data.errors);
        } else {
            context.commit('error/setCode', response.status, { root: true });
        }
    },
    async resetPassword (context, data) {
        context.commit('setApiStatus', null);
        console.log(data);
        const response = await axios.post('/api/password/reset', {
            params: {
                new_password : data,
                user : context.state.user,
            }
        });
        console.log(response)
        if (response.status === OK) {
            context.commit('setApiStatus', true);
            return false;
        }
        context.commit('setApiStatus', false);
        if (response.status === UNPROCESSABLE_ENTITY) {
            context.commit('setLoginErrorMessages', response.data.errors);
        } else {
            context.commit('error/setCode', response.status, { root: true });
        }
    }

}

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions
}
