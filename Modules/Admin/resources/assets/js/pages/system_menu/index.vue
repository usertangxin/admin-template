<template>
    <div class="m-3 p-3 page-content" style="background-color: var(--color-bg-2);">
        <div class="mb-3">
            <a-space>
                <a-button type="primary" @click="handleExpandAll">
                    {{ isExpandAll ? '收起全部' : '展开全部' }}
                </a-button>
                <a-button type="primary" status="success" @click="handleRefreshCache">刷新菜单缓存</a-button>
                <a-button type="primary" status="danger" @click="handleDeleteCache">删除菜单缓存</a-button>
            </a-space>
        </div>
        <a-table ref="tableRef" row-key="code" :columns="columns" v-model:expandedKeys="expandedKeys" :data="tree"
            :bordered="{
                cell:true,
            }">
            <template #icon="{ record }">
                <component v-if="record.icon" :is="record.icon.split(' ',2)[0] + '-icon'"
                    :icon="record.icon.split(' ',2)[1]"></component>
            </template>
        </a-table>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { Message } from '@arco-design/web-vue';

const props = defineProps(['tree', 'list'])

const tableRef = ref(null);

const isExpandAll = ref(false);
const expandedKeys = ref([]);
const columns = [
    { title: '菜单名称', dataIndex: 'name' },
    { title: '菜单URL', dataIndex: 'url' },
    { title: '菜单类型', dataIndex: 'type' },
    { title: '菜单图标', dataIndex: 'icon', slotName: 'icon' },
    // { title: '菜单编码', dataIndex: 'code' },
    { title: '是否隐藏', dataIndex: 'hidden' },
    { title: '备注', dataIndex: 'remark' },
]

const handleExpandAll = () => {
    isExpandAll.value = !isExpandAll.value;
    tableRef.value.expandAll(isExpandAll.value)
}

const handleRefreshCache = () => {
    axios.get('./refreshSystemMenuCache').then(res => {
        if (res.data.code === 0) {
            Message.success('刷新菜单缓存成功');
        }
    })
}

const handleDeleteCache = () => {
    axios.delete('./cache').then(res => {
        if (res.data.code === 0) {
            Message.success('删除菜单缓存成功');
        } else {
            Message.error('删除菜单缓存失败');
        }
    })
}


</script>