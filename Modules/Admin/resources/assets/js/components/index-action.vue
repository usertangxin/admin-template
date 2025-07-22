<template>
    <div class="mb-3">
        <a-row>
            <a-col flex="auto">
                <a-space>
                    <slot name="left-before"></slot>
                    <slot name="left">
                        <template v-if="!page.props.__page_index__">
                            <a-tooltip mini content="首页">
                                <a-button @click="toIndex">
                                    <template #icon>
                                        <icon icon="fas home"></icon>
                                    </template>
                                </a-button>
                            </a-tooltip>
                        </template>
                        <template v-if="page.props.__page_index__">
                            <slot name="recycle-before"></slot>
                            <slot name="recycle">
                                <a-tooltip mini content="回收站">
                                    <a-button status="normal" @click="toRecycle">
                                        <template #icon>
                                            <icon icon="fas recycle"></icon>
                                        </template>
                                    </a-button>
                                </a-tooltip>
                            </slot>
                            <slot name="recycle-after"></slot>
                        </template>
                        <slot name="refresh-before"></slot>
                        <slot name="refresh">
                            <a-tooltip mini content="刷新">
                                <a-button status="normal" @click="refreshList">
                                    <template #icon>
                                        <icon icon="a refresh"></icon>
                                    </template>
                                </a-button>
                            </a-tooltip>
                        </slot>
                        <slot name="refresh-after"></slot>
                        <slot name="fullscreen-before"></slot>
                        <slot name="fullscreen">
                            <a-tooltip mini content="全屏">
                                <a-button status="normal" @click="changeFullScreen">
                                    <template #icon>
                                        <icon icon="a fullscreen"></icon>
                                    </template>
                                </a-button>
                            </a-tooltip>
                        </slot>
                        <slot name="fullscreen-after"></slot>
                        <a-divider direction="vertical"></a-divider>
                        <template v-if="page.props.__page_index__">
                            <slot name="create-before"></slot>
                            <slot name="create">
                                <a-button @click="toCreate" type="primary" status="normal">创建</a-button>
                            </slot>
                            <slot name="create-after"></slot>
                            <slot name="destroy-before"></slot>
                            <slot name="destroy">
                                <a-button type="primary" status="danger">删除</a-button>
                            </slot>
                            <slot name="destroy-after"></slot>
                        </template>
                        <template v-if="page.props.__page_recycle__">
                            <slot name="recovery-before"></slot>
                            <slot name="recovery">
                                <a-button type="primary" status="success">恢复</a-button>
                            </slot>
                            <slot name="recovery-after"></slot>
                            <slot name="real-destroy-before"></slot>
                            <slot name="real-destroy">
                                <a-button type="primary" status="danger">永久删除</a-button>
                            </slot>
                            <slot name="real-destroy-after"></slot>
                        </template>
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
                            <a-input-search v-model="store.searchQuery.value.fast_search" @search="store.resetSearchQuery"
                                @press-enter="store.resetSearchQuery" placeholder="请输入内容并回车" />
                        </slot>
                        <slot name="search-input-after"></slot>
                        <slot name="search-before"></slot>
                        <slot name="search">
                            <a-tooltip mini content="更多搜索选项" position="br">
                                <a-button status="normal">
                                    <template #icon>
                                        <icon icon="fas magnifying-glass-arrow-right"></icon>
                                    </template>
                                </a-button>
                            </a-tooltip>
                        </slot>
                        <slot name="search-after"></slot>
                        <a-divider direction="vertical"></a-divider>
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
                    </slot>
                    <slot name="right-after"></slot>
                </a-space>
            </a-col>
        </a-row>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue'
import { router, usePage, useRemember } from '@inertiajs/vue3';
import { useInjectIndexShareStore } from '../IndexShare';
import { recursiveForEach, recursiveMap } from '../util';
import { changeFullScreen } from '../util'

const page = usePage();
const store = useInjectIndexShareStore()
const refreshList = () => {
    store.fetchListData()
}

const selectedKeys = useRemember([], 'indexShareColumnsSelectedKeys' + window.location.href.split('?')[0])
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

const toRecycle = () => {
    router.visit('./recycle')
}

const toIndex = () => {
    if (history.length > 1) {
        history.back()
    } else {
        router.visit('./index')
    }
}

const toCreate = () => {
    router.visit('./create')
}

</script>

<style lang="scss" scoped></style>