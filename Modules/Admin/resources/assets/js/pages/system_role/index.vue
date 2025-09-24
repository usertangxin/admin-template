<template>
    <div class="p-3 m-3 page-content">
        <index-action>
            <template #search>
                <search-col>
                    <a-form-item label="角色名称" field="name">
                        <a-input v-model="store.searchQuery.name"></a-input>
                    </a-form-item>
                </search-col>
            </template>
        </index-action>
        <index-table></index-table>
    </div>
</template>

<script setup>
import { provideIndexShareStore } from '../../IndexShare'

const store = provideIndexShareStore({
    columns: [
        { title: 'ID', dataIndex: 'id', show: false, },
        { title: '角色名称', dataIndex: 'name', },
        { title: '状态', dataIndex: 'status', type: 'dict_tag', dict: 'data_status' },
        { title: '备注', dataIndex: 'remark', },
    ],
    searchQuery: {
        name: '',
    },
})

</script>