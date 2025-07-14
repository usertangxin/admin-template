<template>
    <div class="m-3 p-3 page-content">
        <index-action>
            <template #left>
                <a-button type="primary" @click="handleExpandAll">
                    {{ isExpandAll ? '收起全部' : '展开全部' }}
                </a-button>
                <a-button type="primary" status="success" @click="handleRefreshCache">刷新菜单缓存</a-button>
                <a-button type="primary" status="danger" @click="handleDeleteCache">删除菜单缓存</a-button>
            </template>
        </index-action>
        <index-table ref="tableRef" row-key="code" :pagination="false" v-model:expandedKeys="expandedKeys" :data="tree">
        </index-table>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { Message } from '@arco-design/web-vue';
import { provideIndexShareStore } from '../../IndexShare';

const props = defineProps(['tree', 'list'])

const tableRef = ref(null);

const isExpandAll = ref(false);
const expandedKeys = ref([]);

const store = provideIndexShareStore({
    columns: [
        { title: '菜单名称', dataIndex: 'name' },
        { title: '菜单URL', dataIndex: 'url' },
        { title: '菜单类型', dataIndex: 'type', type: 'dict_tag', dict: 'menu_type' },
        { title: '菜单图标', dataIndex: 'icon', type: 'icon' },
        { title: '菜单编码', dataIndex: 'code' },
        { title: '是否隐藏', dataIndex: 'hidden', type: 'switch' },
        { title: '备注', dataIndex: 'remark' },
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
    axios.put('./refreshSystemMenuCache')
}

const handleDeleteCache = () => {
    axios.delete('./cache')
}


</script>