<template>
    <a-checkbox-group v-bind="$attrs">
        <template v-for="(item, index) in dict_group_by_code[code]" :key="index">
            <a-checkbox :value="item.value" :disabled="item.status === 'disabled'">
                <template v-if="type === 'normal'">{{ item.label }}</template>
                <template v-if="type === 'info'" #checkbox="{ checked }">
                    <a-space align="start" class="custom-checkbox-card" :class="{ 'custom-checkbox-card-checked': checked }">
                        <div class="custom-checkbox-card-mask">
                            <div class="custom-checkbox-card-mask-dot"></div>
                        </div>
                        <div>
                            <div class="custom-checkbox-card-title">
                                {{ merge[item.value]?.label || item.label }}
                            </div>
                            <div v-if="merge[item.value]?.remark || item.remark"
                                v-html="merge[item.value]?.remark || item.remark"
                                class="leading-4 -ml-[22px] mt-2 opacity-70">
                            </div>
                        </div>
                    </a-space>
                </template>
            </a-checkbox>
        </template>
    </a-checkbox-group>
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
.custom-checkbox-card {
    padding: 10px 16px;
    border: 1px solid var(--color-border-2);
    /* border-radius: 4px; */
    box-sizing: border-box;
    margin-left: -5px;
}

.custom-checkbox-card-mask {
    height: 15px;
    width: 15px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    // border-radius: 100%;
    border: 2px solid var(--color-border-2);
    box-sizing: border-box;
}

.custom-checkbox-card-mask-dot {
    width: 7px;
    height: 7px;
    // border-radius: 100%;
}

.custom-checkbox-card-title {
    color: var(--color-text-1);
    font-size: 14px;
    font-weight: bold;
    line-height: 1;
}

// arco-checkbox-disabled

.custom-checkbox-card {
  &:not(.arco-checkbox-disabled &):hover,
  &-checked {
    border-color: rgb(var(--primary-6));
    .custom-checkbox-card-title {
      color: rgb(var(--primary-6));
    }
  }

  &-checked {
    background-color: var(--color-primary-light-1);
    .custom-checkbox-card-mask-dot {
      background-color: rgb(var(--primary-6));
    }
  }

  &:not(.arco-checkbox-disabled &):hover .custom-checkbox-card-mask,
  &-checked .custom-checkbox-card-mask {
    border-color: rgb(var(--primary-6));
  }
}
</style>