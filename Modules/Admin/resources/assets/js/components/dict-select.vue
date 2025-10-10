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
import useDictStore from '../data-share/dict'
import {computed, defineProps} from 'vue'
import { colorMatch } from '../util'

const dictStore = useDictStore()

const dict_group_by_code = computed(() => dictStore.dict_group_by_code)
const props = defineProps({
    code: {
        type: String,
        default: ''
    },
})
</script>

<style scoped lang="scss">
</style>
