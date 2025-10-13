<template>
    <div class=" m-3 p-3 page-content">
        <a-row :gutter="20">
            <a-col flex="none">
                <a-list class=" max-w-[200px]" :virtualListProps="{
                    height: groupHeight,
                }" :data="group_list">
                    <template #header>
                        {{ $t('systemDict.configGroup') }}
                    </template>
                    <template #item="{ item: group, index: group_index }">
                        <a-list-item :class="{ 'group_active': current_group_index == group_index }">
                            <a-list-item-meta class=" cursor-pointer"
                                @click="current_group_index = group_index">
                                <template #title>
                                    <div :title="group.name" class="truncate">{{ group.name }}</div>
                                </template>
                                <template #description>
                                    <div :title="group.remark" class="truncate max-w-[150px]">{{ group.remark }}</div>
                                </template>
                            </a-list-item-meta>
                            <template #actions>
                                <div>
                                    <a-space>
                                        <!-- 不知道该塞些什么 -->
                                    </a-space>
                                </div>
                            </template>
                        </a-list-item>
                    </template>
                </a-list>
            </a-col>
            <a-col flex="1">
                <a-card
                    :title=" $t('systemDict.configItem') + '（ ' + $t('systemDict.configItemAbout', { group: group_list[current_group_index].name }) + ' ）' + group_list[current_group_index].code">
                    <index-table :data="current_group_list" :pagination="pagination" :row-selection="false"
                        @page-change="pagination.current = $event">
                        <template #color="{ record }">
                            <a-tag v-if="record.color" :style="[...colorMatch(record.color)]" bordered>{{ record.label
                                }}</a-tag>
                        </template>
                        <template #action-column="{record}">
                            <a-space></a-space>
                        </template>
                    </index-table>
                </a-card>
            </a-col>
        </a-row>
    </div>
</template>

<script setup>
import { computed, reactive, ref } from 'vue';
import { Message } from '@arco-design/web-vue';
import { colorMatch } from '../../util';
import { provideIndexShareStore } from '../../IndexShare';
import { __ } from '../../i18n';

const props = defineProps(['data'])
const list = computed(function () {
    return props.data.list;
})
const group_list = computed(function () {
    return props.data.group_list;
})

const groupHeight = ref(0)

const store = provideIndexShareStore({
    columns: [
        { title: __('systemDict.label'), dataIndex: 'label' },
        { title: __('systemDict.value'), dataIndex: 'value' },
        { title: __('systemDict.color'), dataIndex: 'color' },
        { title: __('systemDict.status'), dataIndex: 'status', type: 'dict_tag', dict: 'data_status' },
        { title: __('systemDict.remark'), dataIndex: 'remark' },
    ],
    innerFetchListData: false,
})

const setGroupHeight = () => {
    groupHeight.value = window.innerHeight - 100
}
setGroupHeight()
let timer = null
window.addEventListener('resize', () => {
    if (timer) {
        clearTimeout(timer)
    }
    timer = setTimeout(() => {
        setGroupHeight()
    }, 100)
})

const origin_kvs = {};

list.value.forEach(element => {
    if (element.key) {
        origin_kvs[element.key] = element.value;
    }
});

const current_group_index = ref(0);

const current_group_list = computed(function () {
    const group_code = group_list.value[current_group_index.value].code;
    const config_list = list.value.filter(function (item) {
        return item.code == group_code;
    })
    return config_list;
})

const pagination = reactive({
    total: computed(() => current_group_list.value.length),
    current: 1,
    pageSize: 10,
})

</script>

<style scoped lang="scss">
.page-content :deep(.arco-list-header) {
    background-color: var(--color-neutral-2);
}

.page-content :deep(.arco-card-header) {
    background-color: var(--color-neutral-2);
}

.page-content :deep(.arco-form-size-large .arco-form-item-label-col) {
    line-height: 20px;
    padding-top: 8px;
}

.group_active {
    background-color: rgba(var(--primary-6), .05);

    :deep(.arco-list-item-meta-title) {
        color: rgb(var(--primary-6));
    }
}
</style>