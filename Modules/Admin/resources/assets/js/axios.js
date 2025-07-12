import axios from 'axios';
import { Message } from '@arco-design/web-vue';

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.interceptors.response.use(function (response) {
    const data = response.data
    if (response.config.method !== 'get') {
        if (data.code === 0) {
            Message.success(data.message);
        } else {
            Message.error(data.message);
        }
    }
    return data;
}, function (error) {
    Message.error(error.response.data.message);
    return Promise.reject(error);
})

window.axios = axios;



