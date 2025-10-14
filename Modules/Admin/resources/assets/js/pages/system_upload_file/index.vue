<template>
    <div class="m-3 p-3 page-content">
        <index-action>
            <template #search>
                <search-col>
                    <a-form-item :label="$t('systemUploadFile.storageMode')" field="storage_mode">
                        <dict-select v-model="store.searchQuery.storage_mode" code="storage_mode"
                            :placeholder="$t('systemUploadFile.placeholderStorageMode')"></dict-select>
                    </a-form-item>
                </search-col>
                <search-col>
                    <a-form-item :label="$t('systemUploadFile.uploadMode')" field="upload_mode">
                        <dict-select v-model="store.searchQuery.upload_mode" code="upload_mode"
                            :placeholder="$t('systemUploadFile.placeholderUploadMode')"></dict-select>
                    </a-form-item>
                </search-col>
                <search-col>
                    <a-form-item :label="$t('systemUploadFile.originName')" field="origin_name">
                        <a-input v-model="store.searchQuery.origin_name"
                            :placeholder="$t('systemUploadFile.placeholderOriginName')"></a-input>
                    </a-form-item>
                </search-col>
                <search-col>
                    <a-form-item :label="$t('systemUploadFile.objectName')" field="object_name">
                        <a-input v-model="store.searchQuery.object_name"
                            :placeholder="$t('systemUploadFile.placeholderObjectName')"></a-input>
                    </a-form-item>
                </search-col>
                <search-col>
                    <a-form-item :label="$t('systemUploadFile.mimeType')" field="mime_type">
                        <a-input v-model="store.searchQuery.mime_type"
                            :placeholder="$t('systemUploadFile.placeholderMimeType')"></a-input>
                    </a-form-item>
                </search-col>
                <search-col>
                    <a-form-item :label="$t('systemUploadFile.suffix')" field="suffix">
                        <a-input v-model="store.searchQuery.suffix"
                            :placeholder="$t('systemUploadFile.placeholderSuffix')"></a-input>
                    </a-form-item>
                </search-col>
                <search-col>
                    <a-form-item :label="$t('systemUploadFile.sizeByte')" field="size_byte">
                        <input-range v-model="store.searchQuery.size_byte"></input-range>
                    </a-form-item>
                </search-col>
                <search-col>
                    <a-form-item :label="$t('systemUploadFile.uploadTime')" field="created_at">
                        <a-range-picker v-model="store.searchQuery.created_at"
                            value-format="YYYY-MM-DD"></a-range-picker>
                    </a-form-item>
                </search-col>
            </template>
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
                <a-button type="primary" size="small" @click="handleGetTemporaryUrl(record)">
                    {{ $t('systemUploadFile.getTemporaryUrl') }}
                </a-button>
            </template>
            <template #action-update></template>
        </index-table>

        <a-modal :title="$t('systemUploadFile.getTemporaryUrl')" v-model:visible="showTemporaryUrlModal" width="400px" :hide-cancel="true"
            :closable="false" :ok-text="$t('global.close')" @close="temporaryUrl = ''">
            <a-input-group>
                <a-input-number v-model="temporaryUrlExpireValue" :min="1"
                    :placeholder="$t('systemUploadFile.placeholderTemporaryUrlExpireValue')"></a-input-number>
                <a-select v-model="temporaryUrlExpire">
                    <a-option value="minute">{{ $t('systemUploadFile.minute') }}</a-option>
                    <a-option value="hour">{{ $t('systemUploadFile.hour') }}</a-option>
                    <a-option value="day">{{ $t('systemUploadFile.day') }}</a-option>
                </a-select>
                <a-button type="primary" @click="handleGetTemporaryUrl()">
                    {{ $t('systemUploadFile.getTemporaryUrl') }}
                </a-button>
            </a-input-group>
            <div v-if="temporaryUrl" class=" max-w-[100%] mt-3 flex flex-col items-center">
                <a-link class="break-all" :href="temporaryUrl" target="_blank">{{ temporaryUrl }}</a-link>
                <a-button class="text-red-500 w-[100px]" @click="handleCopyTemporaryUrl()">
                    {{ $t('systemUploadFile.copy') }}
                </a-button>
            </div>
        </a-modal>

    </div>
</template>

<script setup>
import { ref } from 'vue';
import { Message } from '@arco-design/web-vue';
import moment from 'moment';
import { provideIndexShareStore } from '../../IndexShare'
import { __ } from '../../i18n';

const currentRecord = ref(null);
const showTemporaryUrlModal = ref(false);
const temporaryUrlExpire = ref('minute');
const temporaryUrlExpireValue = ref(1);
const temporaryUrl = ref('');

const store = provideIndexShareStore({
    columns: [
        { title: __('systemUploadFile.preview'), dataIndex: 'preview', width: 85, },
        { title: __('systemUploadFile.storageMode'), dataIndex: 'storage_mode', width: 135, type: 'dict_tag', dict: 'storage_mode', },
        { title: __('systemUploadFile.uploadMode'), dataIndex: 'upload_mode', width: 135, type: 'dict_tag', dict: 'upload_mode', },
        { title: __('systemUploadFile.originName'), dataIndex: 'origin_name', ellipsis: true, width: 150, tooltip: true, },
        { title: __('systemUploadFile.objectName'), dataIndex: 'object_name', show: false, },
        { title: __('systemUploadFile.hash'), dataIndex: 'hash', show: false, },
        { title: __('systemUploadFile.mimeType'), dataIndex: 'mime_type', show: false, },
        { title: __('systemUploadFile.storagePath'), dataIndex: 'storage_path', ellipsis: true, width: 150, tooltip: true, },
        { title: __('systemUploadFile.suffix'), dataIndex: 'suffix', width: 80, },
        { title: __('systemUploadFile.sizeByte'), dataIndex: 'size_byte', },
        { title: __('systemUploadFile.url'), dataIndex: 'url', type: 'link', ellipsis: true, width: 150, },
        { title: __('systemUploadFile.remark'), dataIndex: 'remark', },
    ],
    searchQuery: {
        storage_mode: '',
        upload_mode: '',
        origin_name: '',
        object_name: '',
        hash: '',
        mime_type: '',
        storage_path: '',
        suffix: '',
        size_byte: [],
        url: '',
        remark: '',
        created_at: [],
    }
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
    request.get('./temporary-url',{
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