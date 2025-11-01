<template>
    <div class="p-3 m-3 page-content">
        <index-action>
            <template #search>
                <search-col>
                    <a-form-item field="user_id" :label="$t('user_commission_log.user_id')">
                        <remote-select url="/web/user/User/index" labelField="username" valueField="id" v-model="store.searchQuery.user_id" :placeholder="$t('user_commission_log.userIdPlaceholder')"/>
                    </a-form-item>
                </search-col>
                <search-col>
                    <a-form-item field="memo" :label="$t('user_commission_log.memo')">
                        <a-input v-model="store.searchQuery.memo" :placeholder="$t('user_commission_log.memoPlaceholder')"/>
                    </a-form-item>
                </search-col>
            </template>
            <template #recycle></template>
            <template #destroy></template>
        </index-action>
        <index-table>
            <template #action-update></template>
            <template #action-destroy></template>
        </index-table>
    </div>
</template>

<script setup>
import {provideIndexShareStore} from '/Modules/Admin/resources/assets/js/IndexShare'
import {__} from '/Modules/Admin/resources/assets/js/i18n'

const store = provideIndexShareStore({
    columns: [
        {title: __('user_commission_log.id'), dataIndex: 'id', show: false,},
        {title: __('user_commission_log.user_id'), dataIndex: 'user.username',},
        {title: __('user_commission_log.commission'), dataIndex: 'commission',},
        {title: __('user_commission_log.before'), dataIndex: 'before',},
        {title: __('user_commission_log.after'), dataIndex: 'after',},
        {title: __('user_commission_log.memo'), dataIndex: 'memo',},
        {title: __('user_commission_log.created_at'), dataIndex: 'created_at',},
        {title: __('user_commission_log.created_by'), dataIndex: 'created_by', show: false,},
    ],
    searchQuery: {
        user_id: '',
        memo: '',
    },
})
</script>
