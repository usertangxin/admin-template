<template>
    <a-select :allow-clear="true" :allow-search="true" v-bind="$attrs">
        <template v-for="(item, index) in dict_group_by_code[code]" :key="index">
            <a-option :value="item.value" :disabled="item.status === 'disabled'">
                {{ item.label }}
            </a-option>
        </template>
    </a-select>
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
})
</script>

<style scoped lang="scss">
</style>