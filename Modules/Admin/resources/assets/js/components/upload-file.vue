<template>
    <a-upload :is="Upload" @before-upload="beforeUpload" :accept="comAccept" :custom-request="customRequest"
        v-bind="$attrs">
        <template v-for="(key, index) in Object.keys($slots)" #[key]>
            <slot :name="key"></slot>
        </template>
    </a-upload>
</template>
<script setup>
import { config_map } from '../data-share/config'
import { Message } from '@arco-design/web-vue';
import Decimal from 'decimal.js'
import _ from 'lodash';
import { computed } from 'vue';

const props = defineProps([
    'onBeforeUpload',
    'accept',
    // 最大文件大小, 单位字节
    'fileSize',
    'storageMode',
])

const comAccept = computed(() => {
    if (props.accept) {
        return props.accept
    }
    const exts = config_map.value['upload_allow_file'].value.replace(/\s/g, '').split(',');
    return _.map(exts, ext => ext.startsWith('.') ? ext : `.${ext}`).join(',');
})

const beforeUpload = (file) => {
    if (props.onBeforeUpload) {
        return props.onBeforeUpload(file)
    }
    const fileSize = props.fileSize || config_map.value['upload_size'].value
    if (file.size > fileSize) {
        const MB = new Decimal(fileSize).div(1024 * 1024).toFixed(2)
        Message.error('文件大小不能超过' + MB + 'MB')
        return false
    }
    return true;
};

const customRequest = (option) => {
    const { onProgress, onError, onSuccess, fileItem, name } = option
    const data = new FormData();
    data.append('file', fileItem.file);
    props.storageMode && data.append('storage_mode', props.storageMode);
    axios.post(route('web.admin.SystemUploadFile.upload'), data).then(res => {
        onSuccess(res.data)
    }).catch(err => {
        onError(err)
    })
}
</script>