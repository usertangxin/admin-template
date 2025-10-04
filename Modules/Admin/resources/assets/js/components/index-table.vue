<template>
    <a-table :ref="tableFunRef" :bordered="{
        cell: true,
    }" :row-key="rowKey" :row-selection="comRowSelection" v-model:selectedKeys="store.selectedKeys"
        :columns="comColumns" :data="comData" :pagination="pagination" @page-change="handlePageChange"
        @page-size-change="handlePageSizeChange" @sorter-change="handleSorterChange" v-bind="$attrs">
        <template v-for="(column, index) in comColumns" :key="index" v-slot:[column.slotName]="scope">
            <slot :name="column.slotName" v-bind="scope">
                <template v-if="column.slotName === 'action-column'">
                    <a-space wrap class="-mb-2">
                        <slot name="action-column-before" v-bind="scope"></slot>
                        <slot name="action-read" v-bind="scope">
                            <a-button v-if="!$slots['action-read']" size="medium" type="primary"
                                @click="handleDetail(scope.record)">
                                详情
                            </a-button>
                        </slot>
                        <template v-if="page.props.__page_index__">
                            <slot name="action-update" v-bind="scope">
                                <a-button v-if="!$slots['action-update']" size="medium" type="primary" status="warning"
                                    @click="handleUpdate(scope.record)">
                                    编辑
                                </a-button>
                            </slot>
                            <slot name="action-destroy" v-bind="scope">
                                <a-popconfirm v-if="!$slots['action-destroy']" content="确定删除吗？"
                                    @ok="handleDestroy(scope.record)">
                                    <a-button size="medium" status="danger">
                                        删除
                                    </a-button>
                                </a-popconfirm>
                            </slot>
                        </template>
                        <template v-if="page.props.__page_recycle__">
                            <slot name="action-real-destroy" v-bind="scope">
                                <a-popconfirm v-if="!$slots['action-real-destroy']" content="确定永久删除吗？"
                                    @ok="handleRealDestroy(scope.record)">
                                    <a-button size="medium" status="danger">
                                        永久删除
                                    </a-button>
                                </a-popconfirm>
                            </slot>
                        </template>
                        <template v-if="page.props.__page_recycle__">
                            <slot name="action-recovery" v-bind="scope">
                                <a-popconfirm v-if="!$slots['action-recovery']" content="确定恢复吗？"
                                    @ok="handleRecovery(scope.record)">
                                    <a-button size="medium" status="success">
                                        恢复
                                    </a-button>
                                </a-popconfirm>
                            </slot>
                        </template>
                        <slot name="action-column-after" v-bind="scope"></slot>
                    </a-space>
                </template>
                <template v-else-if="!column.type">
                    <template v-if="column.tooltip">
                        <a-tooltip :content="column.tooltip + ''">
                            {{ scope.record[column.dataIndex] || '' }}
                        </a-tooltip>
                    </template>
                    <template v-else>
                        {{ scope.record[column.dataIndex] || '' }}
                    </template>
                </template>
                <template v-else-if="column.type === 'image'">
                    <a-image-preview-group>
                        <a-image class="w-[70px] h-[70px]"
                            v-for="(item, index) in analysisMedia(scope.record[column.dataIndex])" :key="index"
                            :src="item" />
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
                        v-model="scope.record[column.dataIndex]"
                        :disabled="scope.record[column.dataIndex + '_disabled'] ?? column.disabled ?? false"
                        :checked-value="column.checkedValue ?? true" :unchecked-value="column.uncheckedValue ?? false"
                        :checked-text="column.checkedText ?? ''" :unchecked-text="column.uncheckedText ?? ''"
                        :beforeChange="async (newValue) => await handleSwitchBeforeChange(newValue, scope.record, column.dataIndex)">
                        <template #checked-icon>
                            <a-icon icon="check" />
                        </template>
                        <template #unchecked-icon>
                            <a-icon icon="close" />
                        </template>
                    </a-switch>
                </template>
                <template v-else-if="column.type === 'link'">
                    <a-link :href="scope.record[column.dataIndex]" target="_blank">
                        {{ scope.record[column.dataIndex] }}
                    </a-link>
                </template>
                <template v-else>
                    <component :is="column.type" :value="scope.record[column.dataIndex]" v-bind="column"></component>
                </template>
            </slot>
        </template>
    </a-table>
</template>

<script setup>
import { computed, ref, watch, getCurrentInstance } from 'vue';
import { useInjectIndexShareStore } from '../IndexShare'
import { router, usePage } from '@inertiajs/vue3';
import { recursiveFilter } from '../util';
import _ from 'lodash'
import qs from 'qs'

let search = location.search;
let params = qs.parse(search, { ignoreQueryPrefix: true })

const page = usePage()
const tableRef = ref(null);
const ins = getCurrentInstance();

const props = defineProps({
    rowKey: {
        type: String,
        default: 'id'
    },
    data: {
        type: Array,
        default: () => null
    }
})


const store = useInjectIndexShareStore()
const comData = computed(() => {
    let data = props.data ?? store.listData
    return data?.map(item => {
        if (params['__multiple__'] === 'true') {
            // 限制选择数量仅限制当前选择数量，外部调用需要做好数量计算
            if (store.selectedKeys.length >= params['__limit__'] && params['__limit__'] > 0) {
                if (!store.selectedKeys.includes(item[props.rowKey])) {
                    item['old_disabled'] ??= item['disabled'] ?? false
                    item['disabled'] = true
                }
            } else {
                item['disabled'] = item['old_disabled']
            }
        }
        return item
    })
})

const pagination = computed(() => {
    return {
        current: store.searchQuery.__page__,
        pageSize: store.searchQuery.__per_page__,
        total: page.props.meta?.total ?? 0,
        showPageSize: true,
        showTotal: true,
        showJumper: true,
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

window.getSelectedKeys = () => {
    return store.selectedKeys
}

const comColumns = computed(() => {
    const newColumns = JSON.parse(JSON.stringify(store.columns))
    const columns = recursiveFilter(newColumns, item => {
        item.slotName ??= item.dataIndex
        item.show ??= true
        if (item.show !== false) {
            return item
        }
    })
    if (!store.actionColumn) {
        return columns
    }
    return [...columns, store.actionColumn]
})

const comRowSelection = computed(() => {
    if (!params['__resource_select__']) {
        return {
            type: 'checkbox',
            showCheckedAll: true,
        }
    }
    return {
        type: params['__multiple__'] === 'true' ? 'checkbox' : 'radio',
        showCheckedAll: params['__multiple__'] && params['__limit__'] == 0,
    }
})

function tableFunRef(a) {
    tableRef.value = a
    ins.exposed = a
}

const handleSwitchBeforeChange = async (newValue, record, dataIndex) => {
    const res = await request.post('./change-status', { ...record, status: newValue })
    return res.data.code === 0
}

const handleSelectionChange = (rowKeys) => {
    store.selectedKeys = rowKeys
}

const handlePageChange = (page) => {
    store.setSearchQueryItem('__page__', page)
}

const handlePageSizeChange = (pageSize) => {
    store.setSearchQueryItem('__per_page__', pageSize)
}

const handleSorterChange = (dataIndex, direction) => {
    if (direction) {
        const o = {}
        o[dataIndex] = direction == 'ascend' ? 'asc' : 'desc'
        store.setSearchQueryItem('__order_by__', o)
    } else {
        store.removeSearchQueryItem('__order_by__')
    }
    store.fetchListData()
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

const handleDetail = (record) => {
    router.visit('./read?id=' + record.id)
}

const handleUpdate = (record) => {
    router.visit('./update?id=' + record.id)
}

const handleDestroy = (record) => {
    request.delete('./destroy', {
        data: {
            ids: record.id,
        }
    }).then(() => {
        router.reload();
    })
}

const handleRealDestroy = (record) => {
    request.delete('./real-destroy', {
        data: {
            ids: record.id,
        }
    }).then(() => {
        router.reload();
    })
}

const handleRecovery = (record) => {
    request.post('./recovery', { ids: record.id, }).then(() => {
        router.reload();
    })
}
</script>
