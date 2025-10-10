<template>
    <a-space>
        <template v-for="(item, index) in dict_group_by_code[code]" :key="index">
            <a-tag v-if="item.value.includes(value)" :style="[...colorMatch(item.color)]"
                   bordered>{{ item.label }}
            </a-tag>
        </template>
    </a-space>
</template>
<script setup>
import useDictStore from '../data-share/dict'
import {computed, defineProps} from 'vue'
import {colorMatch} from '../util'

const dictStore = useDictStore()

const dict_group_by_code = computed(() => dictStore.dict_group_by_code)
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
