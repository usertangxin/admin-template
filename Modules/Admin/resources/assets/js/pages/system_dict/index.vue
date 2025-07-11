<template>
    <div class=" m-3 p-3 page-content" style="background-color: var(--color-bg-2);">
        <a-row :gutter="20">
            <a-col flex="none">
                <a-list :virtualListProps="{
                    height: 530,
                }" :data="group_list">
                    <template #header>
                        字典组
                    </template>
                    <template #item="{ item: group, index: group_index }">
                        <a-list-item :class="{ 'group_active': current_group_index == group_index }">
                            <a-list-item-meta class=" cursor-pointer" :title="group.name" :description="group.remark"
                                @click="current_group_index = group_index"></a-list-item-meta>
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
                    :title="'字典项（ 「 ' + group_list[current_group_index].name + ' 」相关 ）' + group_list[current_group_index].code">
                    <index-table :columns="columns" :actionColumn="{ show: false }"
                        :data="current_group_list">
                        <template #color="{record}">
                            <a-tag v-if="record.color" :style="[...colorMatch(record.color)]" bordered>{{ record.label }}</a-tag>
                        </template>
                    </index-table>
                </a-card>
            </a-col>
        </a-row>
    </div>
</template>

<script setup>
import { computed, ref } from 'vue';
import { Message } from '@arco-design/web-vue';
import { colorMatch } from '../../util';

const props = defineProps(['list', 'group_list'])

const columns = [
    { title: '标签', dataIndex: 'label' },
    { title: '值', dataIndex: 'value' },
    { title: '颜色', dataIndex: 'color' },
    { title: '备注', dataIndex: 'remark' },
];

const origin_kvs = {};

props.list.forEach(element => {
    if (element.key) {
        origin_kvs[element.key] = element.value;
    }
});

const current_group_index = ref(0);

const current_group_list = computed(function () {
    const group_code = props.group_list[current_group_index.value].code;
    const config_list = props.list.filter(function (item) {
        return item.code == group_code;
    })
    return config_list;
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