<template>
    <div class=" m-3 p-3 page-content" style="background-color: var(--color-bg-2);">

        <a-alert class="mb-2">
            温馨提示：切换配置组前，如果当前配置页有更改，记得保存！
        </a-alert>

        <a-row :gutter="20" align="stretch">
            <a-col flex="none">
                <a-list class=" sticky top-6" :virtualListProps="{
                    height: 530,
                }" :data="config_group_list">
                    <template #header>
                        配组组
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
                <a-card :title="'配置项（ 「 ' + config_group_list[current_group_index].name + ' 」相关 ）'">
                    <a-form :model="current_group_config_list" @submit="handleSubmit">
                        <a-row :gutter="16">
                            <recursion-config :config_list="current_group_config_list"></recursion-config>
                        </a-row>
                        <a-form-item>
                            <a-button type="primary" html-type="submit">保存</a-button>
                        </a-form-item>
                    </a-form>
                </a-card>
            </a-col>
        </a-row>
    </div>
</template>

<script setup>
import { computed, ref } from 'vue';
import { router } from '@inertiajs/vue3';
import RecursionConfig from '../../components/recursion-config.vue';
import { Message } from '@arco-design/web-vue';

const props = defineProps(['config_list', 'config_group_list'])

const origin_kvs = [];

function refreshOriginKvs() {
    props.config_list.forEach(element => {
        if (element.key) {
            origin_kvs[element.key] = element.value;
        }
    });
}
refreshOriginKvs()

const current_group_index = ref(0);

const current_group_config_list = computed(function () {
    const group_code = props.config_group_list[current_group_index.value].code;
    const config_list = props.config_list.filter(function (item) {
        return item.group == group_code;
    })
    return config_list;
})

const handleSubmit = (data) => {
    const kvs = [];
    for (const element of data.values) {
        if (element.key) {
            if (origin_kvs[element.key] != element.value) {
                kvs.push({
                    key: element.key,
                    value: element.value
                })
            }
        }
    }
    if (kvs.length == 0) {
        Message.warning('没有需要保存的配置');
        return;
    }
    axios.post('./save', { data: kvs }).then(function () {
        router.reload()
        setTimeout(() => {
            refreshOriginKvs()
        }, 50);
    })
}

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