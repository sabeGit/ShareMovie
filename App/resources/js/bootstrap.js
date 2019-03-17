import { getCookieArray } from './util'

window._ = require('lodash');

require('vue-flash-message/dist/vue-flash-message.min.css');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

axios.defaults.headers.common = {
	'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content,
    'X-Requested-With': 'XMLHttpRequest'
};

axios.defaults.xsrfHeaderName = 'X-CSRF-TOKEN';

// console.log(localStorage.getItem('access_token'))
// axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('access_token');
// console.log(localStorage.getItem('access_token'))
// if (localStorage.getItem('access_token') === null) {
//     axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('access_token');
// }

window.axios.interceptors.request.use(
    config => {
        let token = localStorage.getItem('token')
        if (token){
            config.headers.Authorization = 'Bearer ' + token;
            return config;
        }
        return config;
    }, function (error) { return Promise.reject(error) }
)

window.axios.interceptors.response.use(
    response => response,
    error => error.response || error
)
