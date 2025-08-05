import axios from 'axios';
import { Message } from '@arco-design/web-vue';
import nProgress from 'nprogress';

const instance = axios.create({
    headers: {
        'X-Requested-With': 'XMLHttpRequest',
    }
})

instance.interceptors.request.use(function (config) {
    nProgress.inc()
    return config
})

instance.interceptors.response.use(function (response) {
    nProgress.done()
    const data = response.data
    if (data.code === 0) {
        if (response.config.method !== 'get') {
            Message.success(data.message);
        }
    } else {
        Message.error(data.message);
    }

    return data
}, function (error) {
    nProgress.done()
    Message.error(error.response.data.message);
    return Promise.reject(error);
})

window.request = instance;



