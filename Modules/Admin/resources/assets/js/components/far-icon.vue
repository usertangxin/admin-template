<template>
    <font-awesome-icon :icon="['fab', icon]" />
</template>

<script setup>
defineProps({
    icon: {
        type: String,
        default: ''
    }
})
</script>
