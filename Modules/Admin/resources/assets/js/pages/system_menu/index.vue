<template>
    <div class="m-3 p-3 page-content">
        <index-action>
            <template #left>
                <a-button type="primary" @click="handleExpandAll">
                    {{ isExpandAll ? $t('global.foldAll') : $t('global.unfoldAll') }}
                </a-button>
                <a-button type="primary" status="success" @click="handleRefreshCache">{{ $t('systemMenu.refresh') }}</a-button>
            </template>
            <template #search-input>
                <block/>
            </template>
            <template #search>
                <block/>
            </template>
        </index-action>
        <index-table ref="tableRef" :row-selection="false" row-key="code" :pagination="false" v-model:expandedKeys="expandedKeys" :data="tree">
        </index-table>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { provideIndexShareStore } from '../../IndexShare';
import { router } from '@inertiajs/vue3';
import { __ } from '/Modules/Admin/resources/assets/js/i18n'

const props = defineProps(['data'])
const tree = computed(() => props.data.tree)

const tableRef = ref(null);

const isExpandAll = ref(false);
const expandedKeys = ref([]);

const store = provideIndexShareStore({
    columns: [
        { title: __('systemMenu.name'), dataIndex: 'name' },
        { title: __('systemMenu.url'), dataIndex: 'url' },
        { title: __('systemMenu.type'), dataIndex: 'type', type: 'dict_tag', dict: 'menu_type' },
        { title: __('systemMenu.icon'), dataIndex: 'icon', type: 'icon' },
        { title: __('systemMenu.code'), dataIndex: 'code', show: false },
        // { title: __('systemMenu.isHidden'), dataIndex: 'is_hidden', show: false, type: 'switch' },
        { title: __('systemMenu.remark'), dataIndex: 'remark' },
    ],
    actionColumn: null,
})

const handleExpand = (record) => {
    console.log(record)
}

const handleExpandAll = () => {
    isExpandAll.value = !isExpandAll.value;
    tableRef.value.expandAll(isExpandAll.value)
}

const handleRefreshCache = () => {
    request.put('./refresh-system-menu-cache')
        .then(res => {
            router.reload()
        })
}


</script>