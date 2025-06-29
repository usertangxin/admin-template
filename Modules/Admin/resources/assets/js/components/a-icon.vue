<template>
    <component :is="'icon-' + icon">
    </component>
</template>

<script setup>
defineProps(['icon'])
</script>
