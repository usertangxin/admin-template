<template>
    <div class="p-3 m-3 page-content">
        <index-action>
            <template #search>
                <search-col>
                    <a-form-item label="管理员账号" field="admin_name">
                        <a-input v-model="store.searchQuery.admin_name"></a-input>
                    </a-form-item>
                </search-col>
                <search-col>
                    <a-form-item label="管理员昵称" field="nickname">
                        <a-input v-model="store.searchQuery.nickname"></a-input>
                    </a-form-item>
                </search-col>
                <search-col>
                    <a-form-item label="手机号" field="phone">
                        <a-input v-model="store.searchQuery.phone"></a-input>
                    </a-form-item>
                </search-col>
                <search-col>
                    <a-form-item label="电子邮箱" field="email">
                        <a-input v-model="store.searchQuery.email"></a-input>
                    </a-form-item>
                </search-col>
            </template>
        </index-action>
        <index-table></index-table>
    </div>
</template>

<script setup>
import { provideIndexShareStore } from '../../IndexShare'
import { __ } from '/Modules/Admin/resources/assets/js/i18n'

const store = provideIndexShareStore({
    columns: [
        { title: 'ID', dataIndex: 'id', show: false, },
        { title: __('systemAdmin.avatar'), dataIndex: 'avatar', type: 'image', },
        { title: __('systemAdmin.adminName'), dataIndex: 'admin_name', },
        { title: __('systemAdmin.nickname'), dataIndex: 'nickname', },
        { title: __('systemAdmin.phone'), dataIndex: 'phone' },
        { title: __('systemAdmin.email'), dataIndex: 'email' },
        { title: __('systemAdmin.status'), dataIndex: 'status', type: 'dict_tag', dict: 'data_status' },
        { title: __('systemAdmin.remark'), dataIndex: 'remark', },
        { title: __('global.createdAt'), dataIndex: 'created_at', show: false, },
        { title: __('systemAdmin.loginIp'), dataIndex: 'login_ip', show: false, },
        { title: __('systemAdmin.loggedAt'), dataIndex: 'logged_at', show: false, },
    ],
})

</script>