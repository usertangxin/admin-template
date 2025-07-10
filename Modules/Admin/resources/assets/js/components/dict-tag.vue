<template>
    <a-space>
        <template v-for="(item,index) in dict_value_group_by_code[code]" :key="index">
            <a-tag v-if="item.value.includes(value)">{{item.label}}</a-tag>
        </template>
    </a-space>
</template>
<script setup>
import * as dict from '../data-share/dict'
import { defineProps } from 'vue'

const dict_value_group_by_code = dict.dict_value_group_by_code
const props = defineProps({
    code: {
        type: String,
        default: ''
    },
    value: {
        type: String || Array,
        default: ''
    }
})

</script>