<template>
    <a-upload :file-list="innerFileList" @update:file-list="handleFileListUpdate" @before-upload="handleBeforeUpload"
        :accept="comAccept" :custom-request="customRequest" v-bind="$attrs" :multiple="multiple">
        <template v-for="key in Object.keys($slots)" #[key] :key="key">
            <slot :name="key"></slot>
        </template>
        <template v-if="!$slots['upload-button']" #upload-button>
            <div class="flex flex-col justify-center items-center p-2 pt-3 custom-box">
                <icon icon="fas fa-cloud-arrow-up" class=" text-[30px]" style="color: rgb(22, 93, 255);">
                </icon>
                <div class=" font-bold mt-3 text-[16px]">点击上传或拖拽文件</div>
                <a-tooltip :content="comAccept">
                    <div class=" text-[12px] w-[100px] py-1 pb-3 truncate" style="color: var(--color-text-3);">
                        {{ comAccept }}
                    </div>
                </a-tooltip>
                <a-button class="self-end history-btn" @click.prevent.stop="" type="primary" size="mini">
                    <template #icon>
                        <icon icon="fas fa-folder-open" class=" text-[14px] -mb-[1px]"></icon>
                    </template>
                    历史附件
                </a-button>
            </div>
        </template>
    </a-upload>
</template>

<script setup>
import { config_map } from '../data-share/config';
import { Message } from '@arco-design/web-vue';
import Decimal from 'decimal.js';
import _ from 'lodash';
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
    }
});

const emit = defineEmits(['update:modelValue', 'change']);

// 内部文件列表 - 使用普通数组而非响应式数组存储原始数据
let fileListData = [];
// 响应式引用，用于触发UI更新
const innerFileList = ref([...fileListData]);
// 跟踪已上传成功的文件URL
let uploadedUrls = props.multiple ? [] : null;

// 计算接受的文件类型
const comAccept = computed(() => {
    if (props.accept) {
        return props.accept;
    }
    const exts = config_map.value['upload_allow_file'].value.replace(/\s/g, '').split(',');
    return _.map(exts, ext => ext.startsWith('.') ? ext : `.${ext}`).join(',');
});

// 处理文件列表更新 - 减少更新频率
const handleFileListUpdate = (newList) => {
    // 深度比较，只有实际变化时才更新
    if (!isEqual(newList, fileListData)) {
        fileListData = [...newList];
        // 使用nextTick减少连续更新
        nextTick(() => {
            innerFileList.value = [...fileListData];
            syncUrlsFromFileList();
        });
    }
};

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

// 自定义上传逻辑
const customRequest = (option) => {
    const { onProgress, onError, onSuccess, fileItem } = option;
    const data = new FormData();

    data.append('file', fileItem.file);
    if (props.storageMode) data.append('storage_mode', props.storageMode);
    if (props.uploadMode) data.append('upload_mode', props.uploadMode);

    axios.post(route('web.admin.SystemUploadFile.upload'), data, {
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

            // 更新URL
            updateUrlsWithNewFile(fileUrl);

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

// 更新URL列表
const updateUrlsWithNewFile = (url) => {
    if (!props.multiple) {
        // 单文件模式
        if (uploadedUrls !== url) {
            uploadedUrls = url;
            emitValues();
        }
    } else {
        // 多文件模式 - 避免重复
        if (!uploadedUrls.includes(url)) {
            uploadedUrls = [...uploadedUrls, url];
            emitValues();
        }
    }
};

// 从文件列表同步URL
const syncUrlsFromFileList = () => {
    const successfulUrls = fileListData
        .filter(item => item.status === 'done' && item.response?.url)
        .map(item => item.response.url);

    if (props.multiple) {
        // 多文件模式
        if (!arraysEqual(successfulUrls, uploadedUrls)) {
            uploadedUrls = [...successfulUrls];
            emitValues();
        }
    } else {
        // 单文件模式
        const currentUrl = successfulUrls[0] || null;
        if (currentUrl !== uploadedUrls) {
            uploadedUrls = currentUrl;
            emitValues();
        }
    }
};

// 触发外部值更新
const emitValues = () => {
    // 使用nextTick减少连续触发
    nextTick(() => {
        const emitValue = props.multiple ? [...uploadedUrls] : uploadedUrls;
        emit('update:modelValue', emitValue);
        emit('change', emitValue);
    });
};


// 工具函数：深度比较两个值是否相等
const isEqual = (a, b) => {
    // 处理基本类型和null
    if (a === b) return true;

    // 处理数组
    if (Array.isArray(a) && Array.isArray(b)) {
        if (a.length !== b.length) return false;
        return a.every((item, index) => isEqual(item, b[index]));
    }

    // 处理对象
    if (typeof a === 'object' && a !== null && typeof b === 'object' && b !== null) {
        const keysA = Object.keys(a);
        const keysB = Object.keys(b);

        if (keysA.length !== keysB.length) return false;

        return keysA.every(key => {
            if (!keysB.includes(key)) return false;
            return isEqual(a[key], b[key]);
        });
    }

    return false;
};

// 监听外部值变化
watch(() => props.modelValue, (newValue) => {
    // 避免循环更新
    const currentValue = props.multiple ? [...uploadedUrls] : uploadedUrls;
    if (isEqual(newValue, currentValue)) return;

    nextTick(() => {
        if (!newValue) {
            fileListData = [];
            uploadedUrls = props.multiple ? [] : null;
            innerFileList.value = [];
            return;
        }

        const urls = Array.isArray(newValue) ? newValue : [newValue];
        uploadedUrls = props.multiple ? [...urls] : urls[0];

        // 更新内部文件列表
        fileListData = urls.map(url => ({
            name: url.split('/').pop(),
            status: 'done',
            response: { url },
            url
        }));
        innerFileList.value = [...fileListData];
    });
}, { immediate: true });

// 工具函数：比较数组是否相等
const arraysEqual = (arr1, arr2) => {
    if (!Array.isArray(arr1) || !Array.isArray(arr2) || arr1.length !== arr2.length) {
        return false;
    }
    return arr1.every((val, index) => val === arr2[index]);
};

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