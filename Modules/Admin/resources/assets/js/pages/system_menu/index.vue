<template>
    <div class="m-3 p-3 page-content" style="background-color: var(--color-bg-2);">
        <div class="mb-3">
            <a-space>
                <a-button type="primary" @click="handleExpandAll">
                    {{ isExpandAll ? '收起全部' : '展开全部' }}
                </a-button>
            </a-space>
        </div>
        <a-table ref="tableRef" row-key="code" :columns="columns" v-model:expandedKeys="expandedKeys"
            :data="tree"></a-table>
    </div>
</template>

<script setup>
import { ref } from 'vue';

const props = defineProps(['tree','list'])

const tableRef = ref(null);

const isExpandAll = ref(false);
const expandedKeys = ref([]);
const columns = [
    { title:'菜单名称', dataIndex: 'name'},
    { title: '菜单URL', dataIndex: 'url'},
    { title: '菜单类型', dataIndex: 'type'},
    { title: '菜单图标', dataIndex: 'icon'},
    { title: '菜单编码', dataIndex: 'code'},
    { title: '是否隐藏', dataIndex: 'hidden'},
    { title: '备注', dataIndex: 'remark'},
]

const handleExpandAll = () => {
    isExpandAll.value = !isExpandAll.value;
    tableRef.value.expandAll(isExpandAll.value)
}
</script>