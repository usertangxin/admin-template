<template>
    <template v-for="(config, config_index) in current_config_list()" :key="config_index">
        <template v-if="config.input_type === 'textarea'">
            <a-col :span="24">
                <a-form-item :label="config.name" :field="config.key">
                    <a-textarea v-model="config.value"></a-textarea>
                    <template #extra>
                        <div>{{ config.remark }}</div>
                    </template>
                </a-form-item>
            </a-col>
        </template>
        <template v-else-if="config.input_type === 'input'">
            <a-col :span="24">
                <a-form-item :label="config.name" :field="config.key">
                    <a-input v-model="config.value"></a-input>
                    <template #extra>
                        <div>{{ config.remark }}</div>
                    </template>
                </a-form-item>
            </a-col>
        </template>
        <template v-else-if="config.input_type === 'radio'">
            <a-col :span="24">
                <a-form-item :label="config.name" :field="config.key">
                    <a-radio-group v-model="config.value">
                        <template v-for="(item, index) in config.config_select_data" :key="index">
                            <a-radio :value="item.value">{{ item.label }}</a-radio>
                        </template>
                    </a-radio-group>
                    <template #extra>
                        <div>{{ config.remark }}</div>
                    </template>
                </a-form-item>
            </a-col>
            <RecursionConfig v-if="config.value" :config_list="props.config_list" :p_config="config.key"
                :p_config_value="config.value"></RecursionConfig>
        </template>
        <template v-else-if="config.input_type == 'tabs'">
            <a-col :span="24">
                <a-form-item :label="config.name" :field="config.key">
                    <a-tabs :default-active-key="config.value" type="card-gutter">
                        <a-tab-pane v-for="(tab, tab_index) in config.config_select_data" :title="tab.label"
                            v-bind:key="tab.value" class="pr-4">
                            <a-row :gutter="16">
                                <RecursionConfig :config_list="props.config_list" :p_config="config.key"
                                    :p_config_value="tab.value"></RecursionConfig>
                            </a-row>
                        </a-tab-pane>
                    </a-tabs>
                    <template #extra>
                        <div>{{ config.remark }}</div>
                    </template>
                </a-form-item>
            </a-col>
        </template>
        <template v-else-if="config.input_type === 'wangEditor'">
            <a-col :span="24">
                <a-form-item :label="config.name" :field="config.key">
                    <WangEditor v-model="config.value"></WangEditor>
                    <template #extra>
                        <div>{{ config.remark }}</div>
                    </template>
                </a-form-item>
            </a-col>
        </template>
        <template v-else>
            <div class="p-2">
                {{ config }}
            </div>
        </template>
    </template>
</template>

<script setup>
import { computed } from 'vue'
import RecursionConfig from './recursion-config.vue'
import WangEditor from './wang-editor.vue'

const props = defineProps(['config_list', 'p_config', 'p_config_value'])

const current_config_list = () => {
    return props.config_list.filter(item => {
        if (props.p_config && props.p_config_value) {
            return item.bind_p_config == props.p_config && item.key.startsWith(props.p_config_value);
        }
        return !item.bind_p_config;
    });
}

</script>