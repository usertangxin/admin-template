<template>
    <div class="mb-3">
        <a-row>
            <a-col flex="auto">
                <a-space>
                    <slot name="left-before"></slot>
                    <slot name="left">
                        <slot name="refresh-before"></slot>
                        <slot name="refresh">
                            <a-button status="normal" @click="refreshList">
                                <template #icon>
                                    <icon icon="a refresh"></icon>
                                </template>
                            </a-button>
                        </slot>
                        <slot name="refresh-after"></slot>
                        <slot name="create-before"></slot>
                        <slot name="create">
                            <a-button type="primary" status="normal">创建</a-button>
                        </slot>
                        <slot name="create-after"></slot>
                        <slot name="destroy-before"></slot>
                        <slot name="destroy">
                            <a-button type="primary" status="danger">删除</a-button>
                        </slot>
                        <slot name="destroy-after"></slot>
                    </slot>
                    <slot name="left-after"></slot>
                </a-space>
            </a-col>
            <a-col flex="none">
                <a-space>
                    <slot name="right-before"></slot>
                    <slot name="right">
                        <slot name="search-input-before"></slot>
                        <slot name="search-input">
                            <a-input-search placeholder="请输入搜索内容" />
                        </slot>
                        <slot name="search-input-after"></slot>
                        <slot name="columns-before"></slot>
                        <slot name="columns">
                            <a-dropdown position="br" :popup-max-height="false">
                                <a-tooltip mimi content="控制显示列">
                                    <a-button>
                                        <template #icon>
                                            <icon icon="fas table-columns"></icon>
                                        </template>
                                    </a-button>
                                </a-tooltip>
                                <template #content>
                                    <div class="p-1 min-w-[150px]">
                                        <a-tree :selectable="false" checkable block-node
                                            v-model:checked-keys="selectedKeys" :data="columns" show-line></a-tree>
                                    </div>
                                </template>
                            </a-dropdown>
                        </slot>
                        <slot name="columns-after"></slot>
                        <slot name="recycle-before"></slot>
                        <slot name="recycle">
                            <a-tooltip mini content="回收站">
                                <a-button status="normal">
                                    <template #icon>
                                        <icon icon="fas recycle"></icon>
                                    </template>
                                </a-button>
                            </a-tooltip>
                        </slot>
                        <slot name="recycle-after"></slot>
                        <slot name="search-before"></slot>
                        <slot name="search">
                            <a-tooltip mini content="更多搜索选项" position="br">
                                <a-button status="normal">
                                    <template #icon>
                                        <icon icon="a search"></icon>
                                    </template>
                                </a-button>
                            </a-tooltip>
                        </slot>
                        <slot name="search-after"></slot>
                    </slot>
                    <slot name="right-after"></slot>
                </a-space>
            </a-col>
        </a-row>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue'
import { useInjectIndexShareStore } from '../IndexShare';
import { recursiveForEach, recursiveMap } from '../util';

const store = useInjectIndexShareStore()
const refreshList = () => {
    store.fetchListData()
}

const selectedKeys = ref([])
const columns = ref([])

watch(store.columns, (newVal, oldVal) => {
    const newColumns = JSON.parse(JSON.stringify(newVal))
    columns.value = recursiveMap(newColumns, item => {
        if (item.show !== false && !item.children) {
            selectedKeys.value.push(item.dataIndex)
        }
        return {
            title: item.title, key: item.dataIndex, children: item.children
        }
    })
}, {
    immediate: true,
    deep: true,
})
watch(selectedKeys, (newVal, oldVal) => {
    const waitFire = {}
    recursiveForEach(store.columns.value, (item, key, parent) => {
        if (!selectedKeys.value.includes(item.dataIndex)) {
            item.show = false
        } else {
            item.show = true
            if (parent) {
                waitFire[parent.dataIndex] = parent
            }
        }
    })
    Object.values(waitFire).forEach(item => {
        item.show = true
    })
})

</script>

<style lang="scss" scoped></style>