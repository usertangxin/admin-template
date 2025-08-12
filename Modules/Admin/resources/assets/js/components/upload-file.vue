<template>
    <a-upload v-model:file-list="innerFileList" @before-upload="handleBeforeUpload" @before-remove="handleBeforeRemove"
        :accept="comAccept" :custom-request="customRequest" :multiple="multiple" :limit="limit" :show-remove-button="showRemoveButton && !mergedDisabled" v-bind="$attrs">
        <template v-for="key in Object.keys($slots)" #[key] :key="key">
            <slot :name="key"></slot>
        </template>
        <template v-if="!$slots['upload-button']" #upload-button>
            <div class="flex flex-col justify-center items-center p-2 pt-3 custom-box">
                <div class="relative">
                    <div
                        class=" left-0 top-0 right-0 bottom-0 m-auto translate-y-[3px] absolute w-[12px] h-[20px] bg-white">
                    </div>
                    <icon icon="fas fa-cloud-arrow-up" class="relative text-[30px]"
                        style="color: rgb(var(--primary-6));">
                    </icon>
                </div>
                <div class=" font-bold mt-3 text-[16px]">点击上传或拖拽文件</div>
                <a-tooltip :content="comAccept + ''">
                    <div class=" text-[12px] w-[100px] py-1 pb-3 truncate" style="color: var(--color-text-3);">
                        {{ comAccept }}
                    </div>
                </a-tooltip>
                <a-button class="history-btn" @click.prevent.stop="visibleResourceModel = true" type="primary"
                    size="mini">
                    <template #icon>
                        <icon icon="fas fa-folder-open" class=" text-[14px] -mb-[1px]"></icon>
                    </template>
                    历史附件
                </a-button>
            </div>
        </template>
    </a-upload>
    <resource-model v-model:visible="visibleResourceModel" :multiple="multiple" :limit="limit - innerFileList.length"
        :src="route('web.admin.SystemUploadFile.index') + '?&mime_type=' + mimeType" @ok="handleOk"></resource-model>
</template>

<script setup>
import { config_map } from '../data-share/config';
import { Message } from '@arco-design/web-vue';
import Decimal from 'decimal.js';
import _, { multiply } from 'lodash';
import { computed, ref, watch, nextTick, inject, provide } from 'vue';
import axios from 'axios';
import { useFormItem } from '@arco-design/web-vue';

const { mergedDisabled } = useFormItem();

// 定义组件属性
const props = defineProps({
    modelValue: {
        type: [String, Array, null],
        default: null
    },
    onBeforeUpload: {
        type: Function,
        default: null
    },
    accept: {
        type: String,
        default: ''
    },
    fileSize: {
        type: Number,
        default: 0
    },
    showRemoveButton: {
        type: Boolean,
        default: true
    },
    storageMode: {
        type: String,
        default: ''
    },
    uploadMode: {
        type: String,
        default: ''
    },
    multiple: {
        type: Boolean,
        default: false
    },
    limit: {
        type: Number,
        default: 0
    },
    remark: {
        type: String,
        default: ''
    },
});

const emit = defineEmits(['update:modelValue', 'change']);

const visibleResourceModel = ref(false);

// 响应式引用，用于触发UI更新
const innerFileList = ref([]);

// 计算接受的文件类型
const comAccept = computed(() => {
    if (props.accept) {
        return props.accept;
    }
    const exts = config_map.value['upload_allow_file'].value.replace(/\s/g, '').split(',');
    return _.map(exts, ext => ext.startsWith('.') ? ext : `.${ext}`).join(',');
});
const mimeType = computed(() => {
    return comAccept.value.replace(/\./g, '');
});

// 处理上传前的校验
const handleBeforeUpload = (file) => {
    if (props.onBeforeUpload) {
        return props.onBeforeUpload(file);
    }

    const fileSize = props.fileSize || config_map.value['upload_size'].value;
    if (file.size > fileSize) {
        const MB = new Decimal(fileSize).div(1024 * 1024).toFixed(2);
        Message.error(`文件大小不能超过${MB}MB`);
        return false;
    }

    return true
};

const handleOk = (selectedKeys) => {
    if (selectedKeys.length == 0) {
        return
    }
    request.get(route('web.admin.SystemUploadFile.index'), {
        params: {
            ids: selectedKeys,
            '__list_type__': 'all',
        }
    }).then(res => {
        if (res.code == 0) {
            if (props.multiple) {
                let arr = Array.isArray(props.modelValue) ? props.modelValue : []
                arr.push(...res.data.map(item => item.url))
                emit('update:modelValue', arr)
            } else {
                emit('update:modelValue', res.data[0].url)
            }
        }
    })
}

// 自定义上传逻辑
const customRequest = (option) => {
    const { onProgress, onError, onSuccess, fileItem } = option;
    const data = new FormData();

    data.append('file', fileItem.file);
    if (props.storageMode) data.append('storage_mode', props.storageMode);
    if (props.uploadMode) data.append('upload_mode', props.uploadMode);
    if (props.remark) data.append('remark', props.remark);

    const CancelToken = axios.CancelToken;
    const source = CancelToken.source();

    fileItem.cancelSource = source

    request.post(route('web.admin.SystemUploadFile.upload'), data, {
        onUploadProgress: (progressEvent) => {
            const percent = progressEvent.total
                ? progressEvent.loaded / progressEvent.total
                : 0;
            onProgress(percent, progressEvent);
        },
        cancelToken: source.token
    }).then(res => {
        // 确保获取到URL
        if (res.code == 0) {
            const fileUrl = res.data[0].url;
            if (!fileUrl) {
                throw new Error('上传成功但未返回URL');
            }

            if (props.multiple) {
                let arr = Array.isArray(props.modelValue) ? props.modelValue : []
                arr.push(fileUrl)
                emit('update:modelValue', arr)
            } else {
                emit('update:modelValue', fileUrl)
            }

            // 通知上传组件成功
            onSuccess({ ...res.data[0], url: fileUrl });
        } else {
            // Message.error(res.message || '上传失败，请重试');
            onError(res.message || '上传失败，请重试');
        }
    }).catch(err => {
        console.error('上传失败:', err);
        // Message.error(err.message || '上传失败，请重试');
        onError(err);
    });
    return {
        abort() {
            source.cancel('上传被取消')
        }
    }
};

const handleBeforeRemove = (item) => {
    if (!Number.isInteger(item.uid)) {
        item.cancelSource && item.cancelSource.cancel('上传被取消')
        return true
    }
    if (props.multiple) {
        let arr = Array.isArray(props.modelValue) ? props.modelValue : []
        arr.splice(item.uid, 1)
        emit('update:modelValue', arr)
    } else {
        emit('update:modelValue', null)
    }
    return false
}

watch(() => props.modelValue, (newValue) => {
    if (props.multiple) {
        let arr = Array.isArray(newValue) ? newValue : []
        innerFileList.value = arr.map((item, index) => {
            return {
                uid: index,
                status: 'done',
                url: item,
                name: item.split('/').pop(),
            }
        })
    } else {
        if (newValue) {
            innerFileList.value = [{
                uid: 0,
                status: 'done',
                url: newValue,
                name: newValue.split('/').pop(),
            }]
        } else {
            innerFileList.value = []
        }
    }
}, {
    deep: true,
    immediate: true,
})

</script>


<style lang="scss" scoped>
.custom-box {
    background-color: var(--color-fill-2);
    color: var(--color-text-1);
    border: 1px dashed var(--color-fill-4);
    // height: 120px;
    width: 220px;
    text-align: center;

    .history-btn {
        box-shadow: 0 0 5px 0 rgb(var(--primary-5));
    }
}
</style>