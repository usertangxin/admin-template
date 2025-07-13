<template>
    <component v-if="icon" :is="icon.split(' ', 2)[0] + '-icon'"
        :icon="icon.split(' ', 2)[1]" v-bind="$attrs"></component>
</template>

<script setup>
defineProps({
    icon: {
        type: String,
        default: ''
    }
})
</script>
