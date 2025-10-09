<template>
    <a-select :allow-clear="true" :allow-search="true" v-bind="$attrs">
        <template v-for="(item, index) in dict_group_list" :key="index">
            <a-option :value="item.code" :disabled="item.status === 'disabled'">
                {{ item.name }}
            </a-option>
        </template>
    </a-select>
</template>
<script setup>
import useDictStore from '/Modules/Admin/resources/assets/js/data-share/dict'
import { defineProps } from 'vue'

const dictStore = useDictStore()

const dict_group_list = dictStore.dict_group_list
</script>

<style scoped lang="scss">
</style>
