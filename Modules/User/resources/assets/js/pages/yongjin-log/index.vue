<template>
    <div class="p-3 m-3 page-content">
        <index-action>
            <template #search>
                <!-- 搜索功能 -->
                <a-form :model="searchForm" layout="inline">
                    <a-form-item field="user_id" :label="$t('user_yongjin_log.user_id')">
                        <a-input v-model="searchForm.user_id" :placeholder="$t('user_yongjin_log.userIdPlaceholder')" />
                    </a-form-item>
                    <a-form-item field="memo" :label="$t('user_yongjin_log.memo')">
                        <a-input v-model="searchForm.memo" :placeholder="$t('user_yongjin_log.memoPlaceholder')" />
                    </a-form-item>
                    <a-form-item>
                        <a-button type="primary" @click="handleSearch">
                            <icon-search /> {{ $t('global.search') }}
                        </a-button>
                        <a-button @click="handleReset">
                            <icon-refresh /> {{ $t('global.reset') }}
                        </a-button>
                    </a-form-item>
                </a-form>
            </template>
        </index-action>
        <index-table></index-table>
    </div>
</template>

<script setup>
import { provideIndexShareStore } from '/Modules/Admin/resources/assets/js/IndexShare'
import { __ } from '/Modules/Admin/resources/assets/js/i18n'

const searchForm = reactive({
    user_id: '',
    memo: ''
})

const handleSearch = () => {
    store.tableRef.value?.search()
}

const handleReset = () => {
    Object.keys(searchForm).forEach(key => {
        searchForm[key] = ''
    })
    store.tableRef.value?.search()
}

const store = provideIndexShareStore({
    columns: [
        { title: __('user_yongjin_log.id'), dataIndex: 'id', show: false, },
        { title: __('user_yongjin_log.user_id'), dataIndex: 'user.nickname', },
        { title: __('user_yongjin_log.yongjin'), dataIndex: 'yongjin', },
        { title: __('user_yongjin_log.before'), dataIndex: 'before', },
        { title: __('user_yongjin_log.after'), dataIndex: 'after', },
        { title: __('user_yongjin_log.memo'), dataIndex: 'memo', },
        { title: __('user_yongjin_log.created_at'), dataIndex: 'created_at', },
        { title: __('user_yongjin_log.created_by'), dataIndex: 'created_by', show: false, },
    ],
    search: () => searchForm
})
</script>