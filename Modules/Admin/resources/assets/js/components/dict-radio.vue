<template>
    <a-radio-group v-bind="$attrs">
        <template v-for="(item, index) in dict_group_by_code[code]" :key="index">
            <a-radio :value="item.value" :disabled="item.status === 'disabled'">
                <template v-if="type === 'normal'">{{ item.label }}</template>
                <template v-if="type === 'info'" #radio="{ checked }">
                    <a-space align="start" class="custom-radio-card" :class="{ 'custom-radio-card-checked': checked }">
                        <div class="custom-radio-card-mask">
                            <div class="custom-radio-card-mask-dot"></div>
                        </div>
                        <div>
                            <div class="custom-radio-card-title">
                                {{ merge[item.value]?.label || item.label }}
                            </div>
                            <div v-if="merge[item.value]?.remark || item.remark"
                                v-html="merge[item.value]?.remark || item.remark"
                                class="leading-4 mt-2 opacity-70">
                            </div>
                        </div>
                    </a-space>
                </template>
            </a-radio>
        </template>
    </a-radio-group>
</template>
<script setup>
import * as dict from '../data-share/dict'
import { defineProps } from 'vue'
import { colorMatch } from '../util'

const dict_group_by_code = dict.dict_group_by_code
const props = defineProps({
    code: {
        type: String,
        default: ''
    },
    type: {
        type: String,
        default: () => 'normal'
    },
    /**
     * 合并数据，键为字典值，合并字典中其他值
     */
    merge: {
        type: Object,
        default: () => ({})
    }
})
</script>

<style scoped lang="scss">
.custom-radio-card {
    padding: 10px 16px;
    border: 1px solid var(--color-border-2);
    /* border-radius: 4px; */
    box-sizing: border-box;
    margin-left: -5px;
}

.custom-radio-card-mask {
    height: 15px;
    width: 15px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 100%;
    border: 2px solid var(--color-border-2);
    box-sizing: border-box;
}

.custom-radio-card-mask-dot {
    width: 7px;
    height: 7px;
    border-radius: 100%;
}

.custom-radio-card-title {
    color: var(--color-text-1);
    font-size: 14px;
    font-weight: bold;
    line-height: 1;
}

// arco-radio-disabled

.custom-radio-card {
  &:not(.arco-radio-disabled &):hover,
  &-checked {
    border-color: rgb(var(--primary-6));
    .custom-radio-card-title {
      color: rgb(var(--primary-6));
    }
  }

  &-checked {
    background-color: var(--color-primary-light-1);
    .custom-radio-card-mask-dot {
      background-color: rgb(var(--primary-6));
    }
  }

  &:not(.arco-radio-disabled &):hover .custom-radio-card-mask,
  &-checked .custom-radio-card-mask {
    border-color: rgb(var(--primary-6));
  }
}
</style>