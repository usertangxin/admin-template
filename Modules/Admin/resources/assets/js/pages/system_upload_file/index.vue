<template>
    <div class="m-3 p-3 page-content">
        <index-action>
            <template #create></template>
        </index-action>
        <index-table>
            <template #preview="{ record }">
                <a-image class="w-[50px] h-[50px]" shape="square" :src="record.url">
                    <template #error>
                        <a-avatar :size="50" shape="square">{{ record.suffix }}</a-avatar>
                    </template>
                </a-image>
            </template>
            <template #action-read="{ record }">
                <a-button type="primary" size="small" @click="handleGetTemporaryUrl(record)">获取临时链接</a-button>
            </template>
            <template #action-update></template>
        </index-table>

        <a-modal title="获取临时链接" v-model:visible="showTemporaryUrlModal" width="400px" :hide-cancel="true"
            :closable="false" ok-text="关闭" @close="temporaryUrl = ''">
            <a-input-group>
                <a-input-number v-model="temporaryUrlExpireValue" :min="1" placeholder="请输入时长"></a-input-number>
                <a-select v-model="temporaryUrlExpire">
                    <a-option value="minute">分钟</a-option>
                    <a-option value="hour">小时</a-option>
                    <a-option value="day">天</a-option>
                </a-select>
                <a-button type="primary" @click="handleGetTemporaryUrl()">获取</a-button>
            </a-input-group>
            <div v-if="temporaryUrl" class=" max-w-[100%] mt-3 flex flex-col items-center">
                <a-link class="break-all" :href="temporaryUrl" target="_blank">{{ temporaryUrl }}</a-link>
                <a-button class="text-red-500 w-[100px]" @click="handleCopyTemporaryUrl()">复制</a-button>
            </div>
        </a-modal>

    </div>
</template>

<script setup>
import { ref } from 'vue';
import { Message } from '@arco-design/web-vue';
import moment from 'moment';
import { provideIndexShareStore } from '../../IndexShare'

const currentRecord = ref(null);
const showTemporaryUrlModal = ref(false);
const temporaryUrlExpire = ref('minute');
const temporaryUrlExpireValue = ref(1);
const temporaryUrl = ref('');

const store = provideIndexShareStore({
    columns: [
        { title: '预览', dataIndex: 'preview', width: 85, },
        { title: '存储模式', dataIndex: 'storage_mode', width: 135, type: 'dict_tag', dict: 'upload_mode', },
        { title: '原文件名', dataIndex: 'origin_name', ellipsis: true, width: 150, tooltip: true, },
        { title: '文件名', dataIndex: 'object_name', show: false, },
        { title: '文件hash', dataIndex: 'hash', show: false, },
        { title: '资源类型', dataIndex: 'mime_type', show: false, },
        { title: '存储目录', dataIndex: 'storage_path', ellipsis: true, width: 150, tooltip: true, },
        { title: '后缀', dataIndex: 'suffix', width: 80, },
        { title: '大小（字节）', dataIndex: 'size_byte', },
        { title: 'url地址', dataIndex: 'url', type: 'link', ellipsis: true, width: 150, },
        { title: '备注', dataIndex: 'remark', show: false, },
    ]
});

const handleGetTemporaryUrl = (record) => {
    if (record) {
        currentRecord.value = record;
        showTemporaryUrlModal.value = true;
        return;
    }
    if (!currentRecord.value) {
        Message.error('请选择文件');
        return;
    }
    if (!temporaryUrlExpireValue.value) {
        Message.error('请输入时长');
        return;
    }
    const expiration = moment.duration(temporaryUrlExpireValue.value, temporaryUrlExpire.value).asSeconds();
    axios.get('./temporary-url',{
        params: {
            id: currentRecord.value.id,
            expiration: expiration,
        }
    }).then(res => {
        temporaryUrl.value = res.data.url;
    })
}

const handleCopyTemporaryUrl = () => {
    if (!temporaryUrl.value) {
        Message.error('请先获取临时链接');
        return;
    }
    const input = document.createElement('input');
    input.value = temporaryUrl.value;
    document.body.appendChild(input);
    input.select();
    document.execCommand('copy');
    document.body.removeChild(input);
    Message.success('复制成功');
}



</script>