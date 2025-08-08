<template>
    <div class="p-3 m-3 page-content">
        <index-action>
            <template #search>
                <a-col span="4">
                    <a-form-item label="账号" field="admin_name">
                        <a-input v-model="store.searchQuery.value.admin_name"></a-input>
                    </a-form-item>
                </a-col>
                <a-col span="4">
                    <a-form-item label="昵称" field="nickname">
                        <a-input v-model="store.searchQuery.value.nickname"></a-input>
                    </a-form-item>
                </a-col>
                <a-col span="6">
                    <a-form-item label="手机号" field="phone">
                        <a-input v-model="store.searchQuery.value.phone"></a-input>
                    </a-form-item>
                </a-col>
                <a-col span="6">
                    <a-form-item label="电子邮箱" field="email">
                        <a-input v-model="store.searchQuery.value.email"></a-input>
                    </a-form-item>
                </a-col>
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
        { title: 'ID', dataIndex: 'id', },
        { title: '头像', dataIndex: 'avatar', type: 'image', },
        { title: '管理员账号', dataIndex: 'admin_name', },
        { title: '昵称', dataIndex: 'nickname', },
        { title: '手机号', dataIndex: 'phone' },
        { title: '电子邮箱', dataIndex: 'email' },
        { title: '状态', dataIndex: 'status', type: 'dict_tag', dict: 'data_status' },
        { title: '备注', dataIndex: 'remark', },
        { title: '创建时间', dataIndex: 'created_at', show: false, },
        { title: '最后登陆IP', dataIndex: 'login_ip', show: false, },
        { title: '最后登陆时间', dataIndex: 'logged_at', show: false, },
    ],
})

</script>