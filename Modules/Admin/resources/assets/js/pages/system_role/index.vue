<template>
    <div class="p-3 m-3 page-content">
        <index-action>
            <template #search>
                <search-col>
                    <a-form-item :label="$t('systemRole.name')" field="name">
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
import { __ } from '/Modules/Admin/resources/assets/js/i18n'

const store = provideIndexShareStore({
    columns: [
        { title: 'ID', dataIndex: 'id', show: false, },
        { title: __('systemRole.name'), dataIndex: 'name', },
        { title: __('systemRole.status'), dataIndex: 'status', type: 'dict_tag', dict: 'data_status' },
        { title: __('systemRole.remark'), dataIndex: 'remark', },
    ],
    searchQuery: {
        name: '',
    },
})

</script>