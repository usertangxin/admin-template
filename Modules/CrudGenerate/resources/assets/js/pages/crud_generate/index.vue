<template>
    <div class="m-3 p-3 page-content">
        <index-action>
            <template #search></template>
        </index-action>
        <index-table></index-table>
    </div>
</template>

<script setup>
import { provideIndexShareStore } from '/Modules/Admin/resources/assets/js/IndexShare'

const store = provideIndexShareStore({
    columns: [
        { title: 'ID', dataIndex: 'id', show: false, },
        { title: '表名', dataIndex: 'table_name', },
        { title: '表注释', dataIndex: 'table_comment', },
        { title: '模块名', dataIndex: 'module_name', },
        { title: '生成方式', dataIndex: 'gen_mode', },
    ],
    searchQuery: {
        name: '',
    },
})
</script>