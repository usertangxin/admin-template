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
import * as dict from '/Modules/Admin/resources/assets/js/data-share/dict'
import { defineProps } from 'vue'

const dict_group_list = dict.dict_group_list
</script>

<style scoped lang="scss">
</style>