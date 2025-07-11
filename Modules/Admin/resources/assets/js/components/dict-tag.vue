<template>
    <a-space>
        <template v-for="(item, index) in dict_value_group_by_code[code]" :key="index">
            <a-tag v-if="item.value.includes(value)" :style="[...computedColor(item.color)]"
                bordered>{{ item.label }}</a-tag>
        </template>
    </a-space>
</template>
<script setup>
import * as dict from '../data-share/dict'
import { defineProps } from 'vue'
import tinycolor from 'tinycolor2'

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

const computedColor = function (color) {
    // 'red' | 'orangered' | 'orange' | 'gold' | 'lime' | 'green' | 'cyan' | 'blue' | 'arcoblue' | 'purple' | 'pinkpurple' | 'magenta' | 'gray'
    let defaultMap = {
        'red': [
            'border-color: rgb(var(--red-6))',
            'color: rgb(var(--red-6))',
            'background-color: rgb(var(--red-1))',
        ],
        'orangered': [
            'border-color: rgb(var(--orangered-6))',
            'color: rgb(var(--orangered-6))',
            'background-color: rgb(var(--orangered-1))',
        ],
        'orange': [
            'border-color: rgb(var(--orange-6))',
            'color: rgb(var(--orange-6))',
            'background-color: rgb(var(--orange-1))',
        ],
        'gold': [
            'border-color: rgb(var(--gold-6))',
            'color: rgb(var(--gold-6))',
            'background-color: rgb(var(--gold-1))',
        ],
        'lime': [
            'border-color: rgb(var(--lime-6))',
            'color: rgb(var(--lime-6))',
            'background-color: rgb(var(--lime-1))',
        ],
        'green': [
            'border-color: rgb(var(--green-6))',
            'color: rgb(var(--green-6))',
            'background-color: rgb(var(--green-1))',
        ],
        'cyan': [
            'border-color: rgb(var(--cyan-6))',
            'color: rgb(var(--cyan-6))',
            'background-color: rgb(var(--cyan-1))',
        ],
        'blue': [
            'border-color: rgb(var(--blue-6))',
            'color: rgb(var(--blue-6))',
            'background-color: rgb(var(--blue-1))',
        ],
        'arcoblue': [
            'border-color: rgb(var(--arcoblue-6))',
            'color: rgb(var(--arcoblue-6))',
            'background-color: rgb(var(--arcoblue-1))',
        ],
        'purple': [
            'border-color: rgb(var(--purple-6))',
            'color: rgb(var(--purple-6))',
            'background-color: rgb(var(--purple-1))',
        ],
        'pinkpurple': [
            'border-color: rgb(var(--pinkpurple-6))',
            'color: rgb(var(--pinkpurple-6))',
            'background-color: rgb(var(--pinkpurple-1))',
        ],
        'magenta': [
            'border-color: rgb(var(--magenta-6))',
            'color: rgb(var(--magenta-6))',
            'background-color: rgb(var(--magenta-1))',
        ],
        'gray': [
            'border-color: rgb(var(--gray-6))',
            'color: rgb(var(--gray-6))',
            'background-color: rgb(var(--gray-1))',
        ],
    };

    

    if (color.startsWith('#')) {
        let baseColor = tinycolor(color)
        if(baseColor.isLight()) {
            baseColor = baseColor.darken(50)
        } else {
            baseColor = baseColor.lighten(50)
        }
        const contrastColor = baseColor.toHexString()
        return [
            'border-color: ' + contrastColor,
            'color: ' + contrastColor,
            'background-color: ' + color,
        ];
    }

    return defaultMap[color] ?? [];
}

</script>