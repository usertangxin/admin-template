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
        { title: __('user.avatar'), dataIndex: 'avatar', type: 'image', },
        { title: __('user.nickname'), dataIndex: 'nickname', },
        { title: __('user.username'), dataIndex: 'username', },
        { title: __('user.phone'), dataIndex: 'phone', },
        { title: __('user.email'), dataIndex: 'email', },
        { title: __('user.yongjin'), dataIndex: 'yongjin', show: false, },
        { title: __('user.yongjin_freeze'), dataIndex: 'yongjin_freeze', show: false, },
        { title: __('user.money'), dataIndex: 'money', show: false, },
        { title: __('user.money_freeze'), dataIndex: 'money_freeze', show: false, },
        { title: __('user.score'), dataIndex: 'score', show: false, },
        { title: __('user.score_freeze'), dataIndex: 'score_freeze', show: false, },
        { title: __('user.sex'), dataIndex: 'sex', type: 'dict_tag', dict: 'sex', },
        { title: __('user.birthday'), dataIndex: 'birthday', },
        { title: __('user.vip'), dataIndex: 'vip', },
        { title: __('user.last_login_ip'), dataIndex: 'last_login_ip', },
        { title: __('user.last_login_type'), dataIndex: 'last_login_type', },
        { title: __('user.status'), dataIndex: 'status', type: 'dict_tag', dict: 'data_status', },
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