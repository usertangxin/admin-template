<template>
    <div class="p-3 m-3 page-content">
        <index-table></index-table>
    </div>
</template>

<script setup>
const props = defineProps(['current_page', 'data', 'per_page', 'last_page', 'total'])
import { provideIndexShareStore } from '../../IndexShare'

const store = provideIndexShareStore({
    columns: [
        { title: 'ID', dataIndex: 'id', },
        { title: '管理员账号', dataIndex: 'admin_name', },
        { title: '昵称', dataIndex: 'nickname', },
        { title: '手机号', dataIndex: 'phone' },
        { title: '电子邮箱', dataIndex: 'email' },
        { title: '状态', dataIndex: 'status', type: 'dict_tag', dict: 'data_status' },
    ],
})

</script>