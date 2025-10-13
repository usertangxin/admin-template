<template>
    <div class="m-3 p-3 page-content">
        <index-action>
            <template #search></template>
        </index-action>
        <index-table>
            <template #action-column-after="scope">
                <a-button size="medium" type="primary"
                          @click="handlePreviewCode(scope.record)">
                    {{ $t('crudGenerate.previewCode') }}
                </a-button>
                <a-popconfirm :content="$t('crudGenerate.confirmGenerate')" @ok="handleGenCode(scope.record)">
                    <a-button size="medium" type="primary" status="danger">
                        {{ $t('crudGenerate.generateCode') }}
                    </a-button>
                </a-popconfirm>
            </template>
        </index-table>
    </div>
</template>

<script setup>
import { provideIndexShareStore } from '/Modules/Admin/resources/assets/js/IndexShare'
import { __ } from '/Modules/Admin/resources/assets/js/i18n'

const store = provideIndexShareStore({
    columns: [
        { title: 'ID', dataIndex: 'id', show: false, },
        { title: __('crudGenerate.table_name'), dataIndex: 'table_name', },
        { title: __('crudGenerate.table_comment'), dataIndex: 'table_comment', },
        { title: __('crudGenerate.module_name'), dataIndex: 'module_name', },
        { title: __('crudGenerate.gen_mode'), dataIndex: 'gen_mode', },
    ],
    searchQuery: {
        name: '',
    },
})

function handlePreviewCode(record) {
    window.open('./preview-code?id=' + record.id)
}

function handleGenCode(record) {
    request.post('./generate-code?id=' + record.id)
}
</script>
