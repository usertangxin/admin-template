<template>
    <font-awesome-icon :icon="['fas', icon]" />
</template>

<script setup>
defineProps({
    icon: {
        type: String,
        default: ''
    }
})
</script>
