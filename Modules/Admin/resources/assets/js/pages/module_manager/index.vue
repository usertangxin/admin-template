<template>
    <div class="m-3 p-3 page-content">
        <index-action>
            <template #back></template>
            <template #fast-search></template>
        </index-action>
        <index-table ref="tableRef" :row-selection="false" row-key="code" :pagination="false"
            :data="data"></index-table>
    </div>
</template>

<script setup>
import { provideIndexShareStore } from '../../IndexShare';

const props = defineProps(['data'])

const store = provideIndexShareStore({
    columns: [
        { title: '模块名称', dataIndex: 'name', width: 200 },
        { title: '模块描述', dataIndex: 'description', width: 200 },
        { title: '模块状态', dataIndex: 'status', type: 'switch', checkedText: '已启用', uncheckedText: '已禁用' },
    ],
    actionColumn: null,
})

</script>