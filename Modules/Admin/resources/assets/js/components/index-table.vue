<template>
    <a-table ref="tableRef" :bordered="{
        cell: true,
    }" :columns="comColumns" :data="data" :pagination="pagination" @page-change="handlePageChange"
        @page-size-change="handlePageSizeChange" v-bind="attrs">
        <template v-for="(column, index) in comColumns" :key="index" v-slot:[column.slotName]="scope">
            <slot :name="column.slotName" v-bind="scope">
                <template v-if="!column.type">
                    {{ scope.record[column.dataIndex] || '' }}
                </template>
                <template v-else-if="column.type === 'image'">
                    <a-image-preview-group>
                        <a-image v-for="(item, index) in analysisMedia(scope.record[column.dataIndex])" :key="index"
                            :src="item" :preview="false" />
                    </a-image-preview-group>
                </template>
                <template v-else-if="column.type === 'icon'">
                    <icon :icon="scope.record.icon"></icon>
                </template>
                <template v-else-if="column.type === 'dict_tag'">
                    <dict-tag :code="column.dict" :value="scope.record[column.dataIndex]"></dict-tag>
                </template>
                <template v-else-if="column.type === 'switch'">
                    <a-switch type="round" :checked="scope.record[column.dataIndex]"
                        :disabled="scope.record[column.dataIndex + '_disabled'] ?? column.disabled ?? false"
                        :checked-value="column.checkedValue ?? true"
                        :unchecked-value="column.uncheckedValue ?? false"
                        :beforeChange="async (newValue) => await handleSwitchBeforeChange(newValue, scope.record, column.dataIndex)">
                        <template #checked-icon>
                            <a-icon icon="check" />
                        </template>
                        <template #unchecked-icon>
                            <a-icon icon="close" />
                        </template>
                    </a-switch>
                </template>
            </slot>
        </template>
    </a-table>
</template>

<script setup>
import { computed, ref, useAttrs, defineExpose, watch } from 'vue';
import { useInjectIndexShareStore } from '../IndexShare'
import { usePage } from '@inertiajs/vue3';

const page = usePage()
const attrs = useAttrs()
const tableRef = ref(null);

const store = useInjectIndexShareStore()
const data = store.listData

const pagination = computed(() => {
    return {
        current: store.searchQuery.__page__,
        pageSize: store.searchQuery.__per_page__,
        total: page.props.total ?? 0,
        showPageSize: true,
    }
})

watch(() => store.searchQuery.__page__, (newVal, oldVal) => {
    if (newVal !== oldVal) {
        getList()
    }
})

watch(() => store.searchQuery.__per_page__, (newVal, oldVal) => {
    if (newVal !== oldVal) {
        getList()
    }
})

const comColumns = computed(() => {
    const columns = [...store.columns]
    columns.forEach(element => {
        element.slotName ??= element.dataIndex
        element.show ??= true
    });
    if (!store.actionColumn.value) {
        return columns
    }
    return [...columns, store.actionColumn.value]
})

const handleSwitchBeforeChange = async (newValue, record, dataIndex) => {
    // return true
}

const handlePageChange = (page) => {
    store.setSearchQueryItem('__page__', page)
}

const handlePageSizeChange = (pageSize) => {
    store.setSearchQueryItem('__per_page__', pageSize)
}

const refreshList = () => {
    store.resetSearchQuery()
}

const getList = () => {
    store.fetchListData()
}

const analysisMedia = (url) => {
    if (!url) return [] // 处理空值情况

    if (Array.isArray(url)) {
        return url.filter(item => item); // 过滤空项
    }

    try {
        if (typeof url === 'string') {
            const parsed = JSON.parse(url);
            return Array.isArray(parsed) ? parsed.filter(item => item) : [parsed];
        }
    } catch (e) {
        console.error('解析媒体URL失败:', e);
        // 尝试其他分割方式
        if (url.includes(',')) return url.split(',').filter(item => item.trim());
        if (url.includes(';')) return url.split(';').filter(item => item.trim());
        if (url.includes('|')) return url.split('|').filter(item => item.trim());
    }

    return [url]; // 单个URL作为数组返回
}

defineExpose({
    selectAll: (...args) => tableRef.value.selectAll(...args),
    select: (...args) => tableRef.value.select(...args),
    expandAll: (...args) => tableRef.value.expandAll(...args),
    expand: (...args) => tableRef.value.expand(...args),
    resetFilters: (...args) => tableRef.value.resetFilters(...args),
    clearFilters: (...args) => tableRef.value.clearFilters(...args),
    resetSorters: (...args) => tableRef.value.resetSorters(...args),
    clearSorters: (...args) => tableRef.value.clearSorters(...args),
})
</script>