<template>
    <a-upload :file-list="innerFileList" @before-upload="handleBeforeUpload" @before-remove="handleBeforeRemove" :accept="comAccept"
        :custom-request="customRequest" :multiple="multiple" :limit="limit" v-bind="$attrs">
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
                <a-tooltip :content="comAccept">
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
import { computed, ref, watch, nextTick } from 'vue';

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
});

const emit = defineEmits(['update:modelValue', 'change']);

const visibleResourceModel = ref(false);

// 内部文件列表 - 使用普通数组而非响应式数组存储原始数据
let fileListData = [];
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

    return true;
};

const handleOk = (selectedKeys) => {
    request.get(route('web.admin.SystemUploadFile.index'), {
        params: {
            ids: selectedKeys,
            '__list_type__': 'all',
        }
    }).then(res => {
        if (res.code == 0) {

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

    request.post(route('web.admin.SystemUploadFile.upload'), data, {
        onUploadProgress: (progressEvent) => {
            const percent = progressEvent.total
                ? Math.round((progressEvent.loaded / progressEvent.total) * 100)
                : 0;
            onProgress({ percent });
        }
    }).then(res => {
        // 确保获取到URL
        if (res.code == 0) {
            const fileUrl = res.data[0].url;
            if (!fileUrl) {
                throw new Error('上传成功但未返回URL');
            }

            if (props.multiple) {
                innerFileList.value.push({
                    uid: res.data[0].hash,
                    status: 'done',
                    url: fileUrl,
                    name: res.data[0].object_name,
                })
            } else {
                innerFileList.value = [{
                    uid: res.data[0].hash,
                    status: 'done',
                    url: fileUrl,
                    name: res.data[0].object_name,
                }]
            }

            // 通知上传组件成功
            onSuccess({ ...res.data[0], url: fileUrl });
        } else {
            // Message.error(res.message || '上传失败，请重试');
            onError(res.message || '上传失败，请重试');
        }
    }).catch(err => {
        console.error('上传失败:', err);
        Message.error(err.message || '上传失败，请重试');
        onError(err);
    });
};

const handleBeforeRemove = (item) => {
    innerFileList.value = innerFileList.value.filter(i => i.uid != item.uid);
}

watch(innerFileList,(newValue) => {
    if(props.multiple) {
        let arr = [];
        _.each(newValue, (item) => {
            arr.push(item.url);
        })
        emit('update:modelValue', arr);
    } else {
        emit('update:modelValue', newValue[0]?.url ?? '');
    }
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