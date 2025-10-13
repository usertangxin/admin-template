<template>
    <div v-show="showSearch" class="mb-3 pb-3 search-box">
        <a-form :model="store.searchQuery" @submit="handleSearchSubmit" ref="searchForm" :auto-label-width="true">
            <a-row :gutter="12">
                <slot name="search"></slot>
                <a-col flex="none">
                    <a-space>
                        <a-button type="primary" html-type="submit">{{ $t('global.search') }}</a-button>
                        <a-button @click="searchForm.resetFields()">{{ $t('global.reset') }}</a-button>
                    </a-space>
                </a-col>
            </a-row>
        </a-form>
    </div>
    <div class="mb-3">
        <a-row>
            <a-col flex="auto">
                <a-space>
                    <slot name="left-before"></slot>
                    <slot name="left">
                        <template v-if="!page.props.__page_index__">
                            <slot name="back-before"></slot>
                            <slot name="back">
                                <a-tooltip mini v-if="!$slots.back" :content="$t('global.prev')">
                                    <a-button @click="toIndex">
                                        <template #icon>
                                            <icon icon="fas arrow-left-long"></icon>
                                        </template>
                                    </a-button>
                                </a-tooltip>
                            </slot>
                            <slot name="back-after"></slot>
                        </template>
                        <template v-if="page.props.__page_index__">
                            <slot name="recycle-before"></slot>
                            <slot name="recycle">
                                <a-tooltip v-if="!$slots.recycle" mini :content="$t('global.recycle')">
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
                            <a-tooltip v-if="!$slots.refresh" mini :content="$t('global.refresh')">
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
                            <a-tooltip v-if="!$slots.fullscreen" mini :content="$t('global.fullscreen')">
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
                                <a-button v-if="!$slots.create" @click="toCreate" type="primary"
                                    status="normal">{{ $t('global.create') }}</a-button>
                            </slot>
                            <slot name="create-after"></slot>
                            <slot name="destroy-before"></slot>
                            <slot name="destroy">
                                <a-popconfirm v-if="!$slots.destroy" :content="$t('indexAction.confirmDestroy')" @ok="handleDestroy">
                                    <a-button type="primary" status="danger"
                                        :disabled="store.selectedKeys.length === 0">{{ $t('global.destroy') }}</a-button>
                                </a-popconfirm>
                            </slot>
                            <slot name="destroy-after"></slot>
                        </template>
                        <template v-if="page.props.__page_recycle__">
                            <slot name="recovery-before"></slot>
                            <slot name="recovery">
                                <a-popconfirm v-if="!$slots.recovery" :content="$t('indexAction.confirmRecovery')" @ok="handleRecovery">
                                    <a-button type="primary" status="success"
                                        :disabled="store.selectedKeys.length === 0">{{ $t('global.recovery') }}</a-button>
                                </a-popconfirm>
                            </slot>
                            <slot name="recovery-after"></slot>
                            <slot name="real-destroy-before"></slot>
                            <slot name="real-destroy">
                                <a-popconfirm v-if="!$slots['real-destroy']" :content="$t('indexAction.confirmRealDestroy')"
                                    @ok="handleRealDestroy">
                                    <a-button type="primary" status="danger"
                                        :disabled="store.selectedKeys.length === 0">{{ $t('global.realDestroy') }}</a-button>
                                </a-popconfirm>
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
                        <slot name="fast-search-before"></slot>
                        <slot name="fast-search">
                            <template v-if="!$slots['fast-search']">
                                <slot name="fast-search-input-before"></slot>
                                <slot name="fast-search-input">
                                    <a-input v-if="!$slots['search-input']"
                                        v-model="store.searchQuery.fast_search"
                                        @press-enter="store.toPage1" :placeholder="$t('indexAction.fastSearch')" :allow-clear="true"
                                        @clear="store.toPage1">
                                        <template #suffix>
                                            <div>
                                                <icon class="cursor-pointer" icon="a search"
                                                    @click="store.toPage1">
                                                </icon>
                                            </div>
                                        </template>
                                    </a-input>
                                </slot>
                                <slot name="fast-search-input-after"></slot>
                                <slot name="fast-search-before"></slot>
                                <slot name="all-search-btn">
                                    <a-tooltip v-if="!$slots['all-search-btn']" mini :content="$t('indexAction.allSearchBtn')" position="br">
                                        <a-button status="normal" @click="showSearch = !showSearch">
                                            <template #icon>
                                                <icon icon="fas magnifying-glass-arrow-right"></icon>
                                            </template>
                                        </a-button>
                                    </a-tooltip>
                                </slot>
                                <slot name="all-search-btn-after"></slot>
                            </template>
                        </slot>
                        <slot name="fast-search-after"></slot>
                        <a-divider direction="vertical"></a-divider>
                        <slot name="columns-before"></slot>
                        <slot name="columns">
                            <a-dropdown v-if="!$slots.columns" position="br" :popup-max-height="false">
                                <a-tooltip mini position="br" :content="$t('indexAction.columnsTooltip')">
                                    <a-button>
                                        <template #icon>
                                            <icon icon="fas table-columns"></icon>
                                        </template>
                                    </a-button>
                                </a-tooltip>
                                <template #content>
                                    <div class="p-1 min-w-[150px]">
                                        <custom-tree checkable block-node v-model:selected-keys="selectedKeys"
                                            v-model:checked-keys="selectedKeys" :multiple="true" :data="columns" show-line></custom-tree>
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
import { onMounted, ref, watch } from 'vue'
import { router, usePage, useRemember } from '@inertiajs/vue3';
import { useInjectIndexShareStore } from '../IndexShare';
import { recursiveForEach, recursiveMap } from '../util';
import { changeFullScreen } from '../util'
import qs from 'qs'

const page = usePage();
const store = useInjectIndexShareStore()
const refreshList = () => {
    store.fetchListData()
}
const searchForm = ref(null)
const showSearch = defineModel('showSearch', {
    default: false,
    type: Boolean
})
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
    recursiveForEach(store.columns, (item, key, parent) => {
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

onMounted(() => {
    searchForm.value.resetFields()
    store.searchQuery = qs.parse(location.search, { ignoreQueryPrefix: true })
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

const handleDestroy = () => {
    request.delete('./destroy', {
        data: {
            ids: store.selectedKeys,
        }
    }).then(() => {
        store.selectedKeys = []
        router.reload();
    })
}

const handleRealDestroy = () => {
    request.delete('./real-destroy', {
        data: {
            ids: store.selectedKeys,
        }
    }).then(() => {
        store.selectedKeys = []
        router.reload();
    })
}

const handleRecovery = () => {
    request.post('./recovery', { ids: store.selectedKeys, }).then(() => {
        store.selectedKeys = []
        router.reload();
    })
}

const handleSearchSubmit = (e) => {
    refreshList()
}

</script>

<style lang="scss" scoped>
.search-box {
    border-bottom: 1px solid var(--color-neutral-3);
}
</style>
