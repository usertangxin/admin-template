<template>
    <div class="m-3 p-3 page-content">
        <index-action>
            <template #back></template>
            <template #fast-search></template>
        </index-action>
        <index-table ref="tableRef" :row-selection="false" row-key="code" :pagination="false" :data="data">
            <template #action-column="scoped">
                <a-space>
                    <a-button @click="handleEnable(scoped.record)" size="medium" type="primary"
                        status="success">{{ $t('moduleManager.enable') }}</a-button>
                    <a-button @click="handleDisable(scoped.record)" size="medium" type="primary"
                        status="warning">{{ $t('moduleManager.disable') }}</a-button>
                    <a-popconfirm :content="$t('moduleManager.confirmDestroy')" @ok="handleDestroy(scoped.record)">
                        <a-button size="medium" type="primary" status="danger">{{ $t('global.destroy') }}</a-button>
                    </a-popconfirm>
                </a-space>
            </template>
        </index-table>
    </div>
</template>

<script setup>
import { provideIndexShareStore } from '../../IndexShare';
import { __ } from '../../i18n';

const props = defineProps(['data'])

const store = provideIndexShareStore({
    columns: [
        { title: __('moduleManager.name'), dataIndex: 'name', width: 200 },
        { title: __('moduleManager.description'), dataIndex: 'description', },
        { title: __('moduleManager.status'), dataIndex: 'status', width: 100, type: 'switch', checkedText: __('moduleManager.enable'), uncheckedText: __('moduleManager.disable') },
    ],
})

const handleEnable = (record) => {
    request.post('./change-status', {
        name: record.name,
        status: true,
    }).then(() => {
        router.reload();
    })
}

const handleDisable = (record) => {
    request.post('./change-status', {
        name: record.name,
        status: false,
    }).then(() => {
        router.reload();
    })
}

const handleDestroy = (record) => {
    request.delete('./destroy', {
        data: {
            name: record.name,
        }
    }).then(() => {
        router.reload();
    })
}


</script>