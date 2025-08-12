<template>
    <div class="p-3 m-3 page-content">
        <index-action>
            <template #search>
                <search-col>
                    <a-form-item label="管理员账号" field="admin_name">
                        <a-input v-model="store.searchQuery.value.admin_name"></a-input>
                    </a-form-item>
                </search-col>
            </template>
        </index-action>
        <index-table></index-table>
    </div>
</template>

<script setup>
import { provideIndexShareStore } from '../../IndexShare'
import { router } from '@inertiajs/vue3';

const store = provideIndexShareStore({
    columns: [
        { title: 'ID', dataIndex: 'id', show: false, },
        { title: '角色名称', dataIndex: 'name', },
        { title: '状态', dataIndex: 'status', type: 'dict_tag', dict: 'data_status' },
        { title: '备注', dataIndex: 'remark', },
    ],
})

</script>