<template>
    <div class=" m-3 p-3 page-content" style="background-color: var(--color-bg-1);">
        <a-row :gutter="20">
            <a-col flex="none">
                <a-list>
                    <template #header>
                        配组组
                    </template>
                    <template v-for="(group, group_index) in config_group_list" :key="group_index">
                        <a-list-item :class="{ 'group_active': current_group_index == group_index }">
                            <a-list-item-meta class=" cursor-pointer" :title="group.name" :description="group.remark"
                                @click="current_group_index = group_index"></a-list-item-meta>
                            <template #actions>
                                <div>
                                    <a-space>

                                    </a-space>
                                </div>
                            </template>
                        </a-list-item>
                    </template>
                </a-list>
            </a-col>
            <a-col flex="1">
                <a-card :title="'配置项（ 「 ' + config_group_list[current_group_index].name + ' 」相关 ）'">
                    <a-form>
                        <a-row :gutter="16">
                            <recursion-config :config_list="current_group_config_list"></recursion-config>
                        </a-row>
                    </a-form>
                </a-card>
            </a-col>
        </a-row>
    </div>
</template>

<script setup>
import { computed, ref } from 'vue';
import RecursionConfig from '../../components/recursion-config.vue'

const props = defineProps(['config_list', 'config_group_list'])

const current_group_index = ref(0);

const current_group_config_list = computed(function () {
    const group_code = props.config_group_list[current_group_index.value].code;
    const config_list = props.config_list.filter(function (item) {
        return item.group == group_code;
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