<template>
    <div class="flex-1 text-center">
        <div class="grid grid-cols-2 gap-2">
            <div class="leading-[36px]">{{ props.keyTitle }}</div>
            <div class="leading-[36px]">{{ props.valueTitle }}</div>
            <template v-for="(item, index) in value" :key="index">
                <div>
                    <a-input v-model="item[0]" :placeholder="`请输入${props.keyTitle}`"></a-input>
                </div>
                <div class="flex">
                    <a-input v-model="item[1]" :placeholder="`请输入${props.valueTitle}`"></a-input>
                    <a-button type="primary" status="danger" @click="removeItem(index)">删除</a-button>
                </div>
            </template>
        </div>
        <div class="mt-2">
            <a-button type="primary" @click="addItem">添加</a-button>
        </div>
    </div>
</template>

<script setup>
import { reactive } from 'vue'

const value = defineModel({
    type: Array,
})

const props = defineProps({
    keyTitle: {
        type: String,
        default: '键'
    },
    valueTitle: {
        type: String,
        default: '值'
    },

})

const addItem = () => {
    if (!value.value) {
        value.value = [['', '']]
        return
    }
    value.value.push(['', ''])
}

const removeItem = (index) => {
    value.value.splice(index, 1)
}

</script>