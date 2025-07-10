<template>
    <a-table ref="tableRef" :columns="comColumns" :data="data" v-bind="attrs" v-on="$listeners">
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
                    <component v-if="scope.record.icon" :is="scope.record.icon.split(' ', 2)[0] + '-icon'"
                        :icon="scope.record.icon.split(' ', 2)[1]"></component>
                </template>
                <template v-else-if="column.type === 'dict_tag'">
                    <dict-tag :code="column.dict" :value="scope.record[column.dataIndex]"></dict-tag>
                </template>
                <template v-else-if="column.type === 'switch'">
                    <a-switch type="round" :checked="scope.record[column.dataIndex]"
                        :disabled="scope.record[column.dataIndex + '_disabled'] ?? column.disabled ?? false"
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
import { computed, ref, useAttrs, onMounted, defineExpose } from 'vue';

const attrs = useAttrs()
const tableRef = ref(null);
const props = defineProps({
    columns: {
        type: Array,
        default: () => []
    },
    actionColumn: {
        type: Object,
        default: () => ({
            title: '操作',
            width: 120,
            fixed: 'right',
            show: true,
        })
    },
    dataSource: {
        type: Array,
        default: () => []
    }
})

const data = ref(props.dataSource)

const comColumns = computed(() => {
    const columns = [...props.columns]
    columns.forEach(element => {
        element.slotName ??= element.dataIndex
    });
    if (!props.actionColumn.show) {
        return columns
    }
    return [...columns, props.actionColumn]
})

const handleSwitchBeforeChange = async (newValue, record, dataIndex) => {
    // return true
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