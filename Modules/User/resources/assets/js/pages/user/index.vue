<template>
    <div class="p-3 m-3 page-content">
        <index-action>
            <template #search>
                <!-- TODO: 搜索 -->
            </template>
        </index-action>
        <index-table></index-table>
    </div>
</template>

<script setup>
import { provideIndexShareStore } from '/Modules/Admin/resources/assets/js/IndexShare'
import { __ } from '/Modules/Admin/resources/assets/js/i18n'

const store = provideIndexShareStore({
    columns: [
        { title: 'ID', dataIndex: 'id', show: false, },
        { title: __('user.avatar'), dataIndex: 'avatar', type: 'image', show: false, },
        { title: __('user.nickname'), dataIndex: 'nickname', show: false, },
        { title: __('user.username'), dataIndex: 'username', },
        { title: __('user.phone'), dataIndex: 'phone', },
        { title: __('user.email'), dataIndex: 'email', },
        { title: __('user.commission'), dataIndex: 'commission', },
        { title: __('user.commission_freeze'), dataIndex: 'commission_freeze', },
        { title: __('user.balance'), dataIndex: 'balance', },
        { title: __('user.balance_freeze'), dataIndex: 'balance_freeze', },
        { title: __('user.integral'), dataIndex: 'integral', },
        { title: __('user.integral_freeze'), dataIndex: 'integral_freeze', },
        { title: __('user.sex'), dataIndex: 'sex', type: 'dict_tag', dict: 'sex', },
        { title: __('user.birthday'), dataIndex: 'birthday', show: false, },
        { title: __('user.vip'), dataIndex: 'vip_level.name', },
        { title: __('user.last_login_ip'), dataIndex: 'last_login_ip', show: false, },
        { title: __('user.last_login_type'), dataIndex: 'last_login_type', show: false, },
        { title: __('user.status'), dataIndex: 'status', type: 'dict_tag', dict: 'data_status', show: false, },
        { title: __('global.createdAt'), dataIndex: 'created_at', show: false, },
        { title: __('global.updatedAt'), dataIndex: 'updated_at', show: false, },
        { title: __('global.deletedAt'), dataIndex: 'deleted_at', show: false, },
        { title: __('user.mini_openid'), dataIndex: 'mini_openid', show: false, },
        { title: __('user.official_openid'), dataIndex: 'official_openid', show: false, },
        { title: __('user.alipay_name'), dataIndex: 'alipay_name', show: false, },
        { title: __('user.alipay_account'), dataIndex: 'alipay_account', show: false, },
    ],
})

</script>
