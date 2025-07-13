import axios from 'axios';
import { Message } from '@arco-design/web-vue';

const instance = axios.create({
    headers: {
        'X-Requested-With': 'XMLHttpRequest',
    }
})

instance.interceptors.response.use(function (response) {
    const data = response.data
    if (response.config.method !== 'get') {
        if (data.code === 0) {
            Message.success(data.message);
        } else {
            Message.error(data.message);
        }
    }

    return data
}, function (error) {
    Message.error(error.response.data.message);
    return Promise.reject(error);
})

window.axios = instance;



