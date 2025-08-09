<template>
    <a-space>
        <template #split>
            -
        </template>
        <a-input-number v-if="Array.isArray(value)" v-model="value[0]" :placeholder="startPlaceholder" :precision="precision" :step="step" :disabled="disabled" :min="min" :max="max < value[1] ? max : value[1]" :readonly="readonly"></a-input-number>
        <a-input-number v-if="Array.isArray(value)" v-model="value[1]" :placeholder="endPlaceholder" :precision="precision" :step="step" :disabled="disabled" :min="min > value[0] ? min : value[0]" :max="max" :readonly="readonly"></a-input-number>
    </a-space>
</template>

<script setup>
import { watch } from 'vue'

const value = defineModel()

const props = defineProps({
    precision: {
        type: Number,
        default: null,
    },
    step: {
        type: Number,
        default: 1,
    },
    disabled: {
        type: Boolean,
        default: false,
    },
    max: {
        type: Number,
        default: Infinity,
    },
    min: {
        type: Number,
        default: -Infinity,
    },
    readonly: {
        type: Boolean,
        default: false,
    },
    'start-placeholder': {
        type: String,
        default: '最小值',
    },
    'end-placeholder': {
        type: String,
        default: '最大值',
    },
})

if (!Array.isArray(value.value)) {
    value.value = []
}

watch(value, (newValue) => {
    if (!Array.isArray(newValue)) {
        value.value = []
    }
}, {
    immediate: true
})


</script>