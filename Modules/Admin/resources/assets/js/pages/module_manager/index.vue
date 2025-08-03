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
                        status="success">启用</a-button>
                    <a-button @click="handleDisable(scoped.record)" size="medium" type="primary"
                        status="warning">禁用</a-button>
                    <a-popconfirm content="确认删除该模块吗？" @ok="handleDestroy(scoped.record)">
                        <a-button size="medium" type="primary" status="danger">删除</a-button>
                    </a-popconfirm>
                </a-space>
            </template>
        </index-table>
    </div>
</template>

<script setup>
import { provideIndexShareStore } from '../../IndexShare';

const props = defineProps(['data'])

const store = provideIndexShareStore({
    columns: [
        { title: '模块名称', dataIndex: 'name', width: 200 },
        { title: '模块描述', dataIndex: 'description', },
        { title: '模块状态', dataIndex: 'status', width: 100, type: 'switch', checkedText: '已启用', uncheckedText: '已禁用' },
    ],
})

const handleEnable = (record) => {
    axios.post('./change-status', {
        name: record.name,
        status: true,
    }).then(() => {
        router.reload();
    })
}

const handleDisable = (record) => {
    axios.post('./change-status', {
        name: record.name,
        status: false,
    }).then(() => {
        router.reload();
    })
}

const handleDestroy = (record) => {
    axios.delete('./destroy', {
        name: record.name,
    }).then(() => {
        router.reload();
    })
}


</script>